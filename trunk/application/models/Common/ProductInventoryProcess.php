<?php
class Service_ProductInventoryProcess
{
    //产品库存操作类
    protected $_date = '';
    protected $_productArr = array();
    protected $_errorMessage = array();

    //操作类型
    public static $_operationType = array(
        1 => 'onWay', // 创建ASN
        2 => 'pending', // 收货
        3 => 'sellable', // 上架
        4 => 'unsellable', // 问题数量
        5 => 'reserved', // 冻结增加 可用减少
        6 => 'shipped', // 已出货增加 冻结减少
    );

    public function __construct()
    {
        $this->_date = date('Y-m-d H:i:s');
    }

    /**
     * @param array $params
     * @return array
     */
    private function validator($params = array())
    {
        $row = array(
            'product_id' => 0,
            'quantity' => 0,
            'customQty' => 0, //用于其它
            'operationType' => 0,
            'warehouse_id' => 0,
            'reference_code' => '', //操作单号
            'application_code' => '', //操作类型
            'note' => ''
        );
        $valid = array('product_id', 'quantity', 'operationType', 'warehouse_id');
        if (!is_array($params) || empty($params)) {
            $this->_errorMessage[] = array('errorCode' => 10001, 'errorMsg' => Ec::Lang('paramsErr'));
            return $row;
        }

        foreach ($row as $key => $val) {
            $row[$key] = isset($params[$key]) ? $params[$key] : '';
        }

        $require = Ec::Lang('require');
        $type = self::$_operationType;
        if (!isset($type[$row['operationType']])) {
            $this->_errorMessage[] = array('errorCode' => 10002, 'errorMsg' => 'operationType ' . $require);
            return $row;
        }
        $warehouse = Common_DataCache::getWarehouse();
        if (!isset($warehouse[$row['warehouse_id']])) {
            $this->_errorMessage[] = array('errorCode' => 10002, 'errorMsg' => 'Warehouse does not exist ' . $require);
            return $row;
        }
        $productRow = Service_Product::getByField($row['product_id'], 'product_id');
        if (empty($productRow)) {
            $this->_errorMessage[] = array('errorCode' => 10002, 'errorMsg' => 'Product does not exist ' . $require);
            return $row;
        }
        $this->_productArr = array(
            'product_sku' => $productRow['product_sku'],
            'customer_id' => $productRow['customer_id'],
            'customer_code' => $productRow['customer_code'],
            'product_barcode' => $productRow['product_barcode'],
        );

        foreach ($valid as $key) {
            if (!isset($row[$key]) || empty($row[$key])) {
                $this->_errorMessage[] = array('errorCode' => 10002, 'errorMsg' => $key . ' ' . $require);
            }
        }
        return $row;
    }


    /**
     * @更新库存
     * @param array $params
     * @return array('state','message'=>array())
     * @return array
     * @throws Exception
     */
    public function update($params = array())
    {
        $result = array('state' => 0, 'message' => array());
        $row = $this->validator($params);
        if (!empty($this->_errorMessage)) {
            $result['message'] = $this->_errorMessage;
            return $result;
        }

        try {
            $isInventory = false;
            $updateRow = array(
                'pi_onway' => 0,
                'pi_pending' => 0,
                'pi_sellable' => 0,
                'pi_unsellable' => 0,
                'pi_reserved' => 0,
                'pi_shipped' => 0,
                'product_id' => $row['product_id'],
                'product_barcode' => $this->_productArr['product_barcode'],
                'warehouse_id' => $row['warehouse_id'],
                'customer_id' => $this->_productArr['customer_id'],
            );
            $inventoryRow = Table_ProductInventory::getInstance()->getByWhProduct($row['warehouse_id'], $row['product_id']);
            if (!empty($inventoryRow)) {
                $isInventory = true;
                foreach ($updateRow as $key => $val) {
                    if (isset($inventoryRow[$key])) {
                        $updateRow[$key] = $inventoryRow[$key];
                    }
                }
            }

            //统一日志
            $addLog = array();
            switch ($row['operationType']) {
                case 1:
                    $updateRow['pi_onway'] = $updateRow['pi_onway'] + $row['quantity'];
                    $addLog[] = array(
                        'from_it_code' => '',
                        'to_it_code' => 'onway',
                        'quantity' => $row['quantity']
                    );
                    break;
                case 2:
                    $updateRow['pi_onway'] = $updateRow['pi_onway'] - $row['customQty'];
                    $updateRow['pi_pending'] = $updateRow['pi_pending'] + $row['quantity'];
                    $addLog[] = array(
                        'from_it_code' => 'onway',
                        'to_it_code' => 'onway',
                        'quantity' => $row['customQty']
                    );
                    $addLog[] = array(
                        'from_it_code' => 'onway',
                        'to_it_code' => 'pending',
                        'quantity' => $row['quantity']
                    );
                    break;
                case 3:
                    $updateRow['pi_sellable'] = $updateRow['pi_sellable'] + $row['quantity'];
                    $updateRow['pi_pending'] = $updateRow['pi_pending'] - $row['quantity'];
                    $addLog[] = array(
                        'from_it_code' => 'pending',
                        'to_it_code' => 'sellable',
                        'quantity' => $row['quantity']
                    );
                    break;
                case 4:
                    $updateRow['pi_pending'] = $updateRow['pi_pending'] - $row['quantity'];
                    $updateRow['pi_unsellable'] = $updateRow['pi_unsellable'] + $row['quantity'];
                    $addLog[] = array(
                        'from_it_code' => 'pending',
                        'to_it_code' => 'unsellable',
                        'quantity' => $row['quantity']
                    );
                    break;
                case 5:
                    $updateRow['pi_reserved'] = $updateRow['pi_reserved'] + $row['quantity'];
                    $updateRow['pi_sellable'] = $updateRow['pi_sellable'] - $row['quantity'];
                    $addLog[] = array(
                        'from_it_code' => 'pending',
                        'to_it_code' => 'unsellable',
                        'quantity' => $row['quantity']
                    );
                    break;
                case 6:
                    $updateRow['pi_shipped'] = $updateRow['pi_shipped'] + $row['quantity'];
                    $updateRow['pi_reserved'] = $updateRow['pi_reserved'] - $row['quantity'];
                    $addLog[] = array(
                        'from_it_code' => 'reserved',
                        'to_it_code' => 'shipped',
                        'quantity' => $row['quantity']
                    );
                    break;
                default:
                    throw new Exception('Internal error! Type Wrong.', 50000);
                    break;
            }

            foreach ($updateRow as $key => $val) {
                if (is_numeric($val) && $val < 0) {
                    throw new Exception('Internal error!', 50000);
                }
            }
            if ($isInventory) {
                if (!Service_ProductInventory::update($updateRow, $inventoryRow['pi_id'], 'pi_id')) {
                    throw new Exception('Internal error! Update Fail.', 50000);
                }
            } else {
                Service_ProductInventory::add($updateRow);
            }
            //日志
            foreach ($addLog as $key => $val) {
                $updateRow['pil_quantity'] = $val['quantity'];
                $updateRow['from_it_code'] = $val['from_it_code'];
                $updateRow['to_it_code'] = $val['to_it_code'];
                $this->addLog($updateRow);
            }

            $result['state'] = 1;
            $result['message'] = array('success');
        } catch (Exception $e) {
            $result['message'] = array(
                'errorCode' => $e->getCode(),
                'errorMse' => $e->getMessage()
            );
        }
        return $result;
    }

    /**
     * @param $row
     * @return bool
     * @throws Exception
     */
    private function addLog($row)
    {
        $user = new Zend_Session_Namespace('userAuthorization');
        $userId = isset($user->userAuth['user_id']) ? $user->userAuth['user_id'] : 0;
        $addLog = array(
            'product_id' => $row['product_id'],
            'warehouse_id' => $row['warehouse_id'],
            'user_id' => $userId,
            'pil_onway' => $row['pi_onway'],
            'pil_pending' => $row['pi_pending'],
            'pil_sellable' => $row['pi_sellable'],
            'pil_unsellable' => $row['pi_unsellable'],
            'pil_reserved' => $row['pi_reserved'],
            'pil_shipped' => $row['pi_shipped'],
            'pil_quantity' => $row['pil_quantity'],
            'from_it_code' => $row['from_it_code'],
            'to_it_code' => $row['to_it_code'],
            'reference_code' => $row['reference_code'],
            'application_code' => $row['application_code'],
            'pil_note' => $row['note'],
            'pil_add_time' => $this->_date
        );
        if (!Service_ProductInventoryLog::add($addLog)) {
            throw new Exception('Internal error! Update Inventory  Fail.', 50000);
            return false;
        }
        return true;
    }

}