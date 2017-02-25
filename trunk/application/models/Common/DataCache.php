<?php

class Common_DataCache
{

    /*
     * 清除全部缓存
     */
    public static function clean($subDir = '', $directoryLevel = 0)
    {
        $cache = Ec::cache($subDir, $directoryLevel);
        return $cache->clean('all');
    }

    public static function getWarehouse($operation = 0, $warehouseId = 0)
    {
        $cacheName = 'warehouse';
        $cache = Ec::cache();
        if ($operation == 1) {
            $cache->remove($cacheName);
        }
        if (!$result = $cache->load($cacheName)) {
            $results = Service_Warehouse::getAll();
            foreach ($results as $k => $v) {
                $result[$v['warehouse_id']] = $v;
            }
            $cache->setLifetime(72 * 3600);
            $cache->save($result, $cacheName);
        }
        if ($warehouseId) {
            $result = $result[$warehouseId];
        }
        return $result;
    }
    public static function getWarehousebh($operation = 0, $warehouseId = 0)
    {
    	$cacheName = 'warehousebh';
    	$cache = Ec::cache();
    	if ($operation == 1) {
    		$cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$results = Service_Warehouse::getByCondition(array('is_beihuo'=>'1'));
    		foreach ($results as $k => $v) {
    			$result[$v['warehouse_id']] = $v;
    		}
    		$cache->setLifetime(72 * 3600);
    		$cache->save($result, $cacheName);
    	}
    	if ($warehouseId) {
    		$result = $result[$warehouseId];
    	}
    	return $result;
    }
    public static function getWarehousejh($operation = 0, $warehouseId = 0)
    {
    	$cacheName = 'warehousejh';
    	$cache = Ec::cache();
    	if ($operation == 1) {
    		$cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$results = Service_Warehouse::getByCondition(array('is_jihuo'=>'1'));
    		foreach ($results as $k => $v) {
    			$result[$v['warehouse_id']] = $v;
    		}
    		$cache->setLifetime(72 * 3600);
    		$cache->save($result, $cacheName);
    	}
    	if ($warehouseId) {
    		$result = $result[$warehouseId];
    	}
    	return $result;
    }
    public static function getCurrency($remove = FALSE)
    {
    	$cacheName	= 'currency';
    	$cache		= Ec::cache();
    	if ($remove) {
    		$cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$rows	= Service_Currency::getCustomQuery('*', 'order by currency_id asc');
    		if (empty($rows)) {
    			return FALSE;
    		}
    		foreach ($rows as $row) {
    			$result[$row['currency_id']]	= $row; 
    		}
    		$cache->setOption('caching',TRUE);
    		$cache->setOption('lifetime',86400);
    		$cache->save($result, $cacheName);
    	}
    	return $result;
    }

    public static function getCurrencyMaps( $currencyCode = '', $remove = FALSE)
    {
        $cacheName	= 'currency_map';
        $cache		= Ec::cache();
        if ($remove) {
            $cache->remove($cacheName);
        }
        if (!$result = $cache->load($cacheName)) {
            $rows	= Service_Currency::getCustomQuery('*', 'order by currency_id asc');
            if (empty($rows)) {
                return FALSE;
            }
            foreach ($rows as $row) {
                $result[$row['currency_code']]	= $row;
            }
            $cache->setOption('caching',TRUE);
            $cache->setOption('lifetime',86400);
            $cache->save($result, $cacheName);
        }
        if( $currencyCode !== '' ) {
            $currencyCode = strtoupper( $currencyCode );
            return isset( $result[ $currencyCode ] ) ? $result[ $currencyCode ] : false;
        }
        return $result;
    }
    
    public static function getCountry($remove = FALSE,$country_id=0)
    {
    	$cacheName	= 'country';
    	$cache		= Ec::cache();
    	if ($remove) {
    		$cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$rows	= Service_Country::getCustomQuery('*', 'order by country_sort DESC');
    		if (empty($rows)) {
    			return FALSE;
    		}
    		foreach ($rows as $row) {
    			$result[$row['country_id']]	= $row;
    		}
    		$cache->setOption('caching',TRUE);
    		$cache->setOption('lifetime',86400);
    		$cache->save($result, $cacheName);
    	}
    	if ($country_id) {
    		return isset($result[$country_id]) ? $result[$country_id] : array();
    	}
    	return $result;
    }
    
    public static function getProductUom($remove = FALSE)
    {
    	$cacheName	= 'productuom';
    	$cache		= Ec::cache();
    	if ($remove) {
    		$cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$rows	= Service_ProductUom::getCustomQuery('*', 'order by pu_sort asc,pu_id asc');
    		if (empty($rows)) {
    			return FALSE;
    		}
    		foreach ($rows as $row) {
    			$result[$row['pu_id']]	= array(
    				'id'	=> $row['pu_id'],
    				'code'	=> $row['pu_code'],
    				'name'	=> $row['pu_name'],
    				'en'	=> $row['pu_name_en']
    			);
    		}
    		$cache->setOption('caching',TRUE);
    		$cache->setOption('lifetime',86400);
    		$cache->save($result, $cacheName);
    	}
    	return $result;
    }

    public static function getProductCategory($categoryId = 0,$remove = FALSE)
    {
    	$cacheName	= 'productcategory';
    	$cache		= Ec::cache();
    	if ($remove) {
    		$cache->remove($cacheName);
    	}
    	$categories = array();
    	if (!$categories = $cache->load($cacheName)) {
    		$rows	= Service_ProductCategory::getCustomQuery('*', 'order by pc_sort_id asc,pc_id asc');
    		if (empty($rows)) {
    			return FALSE;
    		}
    		foreach ($rows as $row) {
    			$categories[$row['pc_id']]	= $row;
    		}
    		$cache->setOption('caching',TRUE);
    		$cache->setOption('lifetime',86400);
    		$cache->save($categories, $cacheName);
    	}
    	if ($categoryId) {
    		return isset($categories[$categoryId]) ? $categories[$categoryId] : array();
    	}
    	return $categories;
    }
    /**
     * @author william-fan
     * @todo 得到分类
     */
    public static function getProductCategoryId($categoryId = 0,$remove = FALSE)
    {
    	$cacheName	= 'productcategoryId';
    	$cache		= Ec::cache();
    	if ($remove) {
    		$cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$rows	= Service_ProductCategory::getByField($categoryId);
    		if (empty($rows)) {
    			return FALSE;
    		}
    		
    		$cache->setOption('caching',TRUE);
    		$cache->setOption('lifetime',86400);
    		$cache->save($result, $cacheName);
    	}
    	return $result;
    }
	/**
	 * @todo 生成
	 */
    public static function getCategory($categoryId = 0, $operation = 0){
    	$cacheName = 'product_category_ecg';
    	$cache = Ec::cache();
    	if ($operation == 1) {
    		$isRemove = $cache->remove($cacheName);
    	}
    	$categories = array();
    	if (!$categories = $cache->load($cacheName)) {
    		$result = Service_ProductCategory::getAll();
    	
    		foreach ($result as $ca) {
    			$categories[$ca['pc_id']] = $ca;
    		}
    		$cache->setLifetime(24 * 3600); // 设置时间，为空则永久
    		$cache->save($categories, $cacheName);
    	}
    	if ($categoryId) {
    		return isset($categories[$categoryId]) ? $categories[$categoryId] : array();
    	}
    	return $categories;
    }
    /**
     * @author william-fan
     * @todo 用于获取运输方式
     */
    public static function getShippingMethod($sm_id = 0, $operation = 0)
    {
    	$cacheName = 'shipping_method';
    	$cache = Ec::cache();
    	if ($operation == 1) {
    		$isRemove = $cache->remove($cacheName);
    	}
    	$arr = array();
    	if (!$arr = $cache->load($cacheName)) {
    		$result = Service_ShippingMethod::getAll();
    
    		foreach ($result as $ca) {
    			if($ca['sm_status']=='1'){
    				$arr[$ca['sm_id']] = $ca;
    			}
    		}
    		$cache->setLifetime(24 * 3600); // 设置时间，为空则永久
    		$cache->save($arr, $cacheName);
    	}
    	if ($sm_id) {
    		return isset($arr[$sm_id]) ? $arr[$sm_id] : array();
    	}
    	return $arr;
    }
    /**
     * @author william-fan
     * @todo 运输方式和国家对应关系
     */
    public static function getShipTypeCountryMap($operation = 0)
    {
    	$cacheName = 'sm_country_map';
    	$cache = Ec::cache();
    	if ($operation == 1) {
    		$isRemove = $cache->remove($cacheName);
    	}
    	if (!$arr = $cache->load($cacheName)) {
    		$country = self::getCountry();
    		$arr = array();
            $smCondition = array(
                'sm_status'=>'1',
            );
            $smArr = self::getShippingMethod();
            if(!empty($smArr)){
                $sm_codeArr = array();
                foreach($smArr as $key=>$value){
                	if($value['sm_status']=='1'){
                		$sm_codeArr[] = $value['sm_code'];
                	}
                }
            }
    		foreach ($country as $k => $v) {
    			$countrySmConditon['country_id'] =  $v['country_id'];
    			$countrySmConditon['or_country_id'] = 0;
    			if(isset($sm_codeArr) && !empty($sm_codeArr)){
    				$countrySmConditon['sm_code_arr'] = $sm_codeArr;
    			}
    			$map = Service_SmCountryMap::getByCondition($countrySmConditon, array(
    					'country_id',
    					'sm_code',
    					'warehouse_id',
    			), 0, 0, 'sm_code', 'sm_code');
    			$v['ship_type'] = $map;
    			if(!empty($map)){
    				$arr[$v['country_id']] = $v;
    			}
    		}
            $cache->setOption('caching',TRUE);
            $cache->setOption('lifetime',86400);
    		$cache->setLifetime(24 * 3600); // 设置时间，为空则永久
    		$cache->save($arr, $cacheName);
    	}
    
    	return $arr;
    }
    
    static function getShipTypeCountryMapByOabCountryId($country_id , $operation =0) {
        $cacheName = 'sm_country_map'.$country_id;
    	$cache = Ec::cache('countrymap',1);
    	if ($operation == 1) {
    		$isRemove = $cache->remove($cacheName);
    	}
    	if (!$arr = $cache->load($cacheName)) {
            $country = self::getCountry();
            if(!isset($country[$country_id])){
                return false;
            }
            $arr = array();
            $smCondition = array(
                'sm_status'=>'1',
            );
            $smArr = self::getShippingMethod();
            if(!empty($smArr)){
                $sm_codeArr = array();
                foreach($smArr as $key=>$value){
                	if($value['sm_status']=='1'){
                		$sm_codeArr[] = $value['sm_code'];
                	}
                }
            }
            /*
    		foreach ($country as $k => $v) {
    			$countrySmConditon['country_id'] =  $v['country_id'];
    			$countrySmConditon['or_country_id'] = 0;
    			if(isset($sm_codeArr) && !empty($sm_codeArr)){
    				$countrySmConditon['sm_code_arr'] = $sm_codeArr;
    			}
    			$map = Service_SmCountryMap::getByCondition($countrySmConditon, array(
    					'country_id',
    					'sm_code',
    					'warehouse_id',
    			), 0, 0, 'sm_code', 'sm_code');
    			$v['ship_type'] = $map;
    			if(!empty($map)){
    				$arr[$v['country_id']] = $v;
    			}
    		}
             * */
            $countrySmConditon['country_id'] =  $country_id;
            $countrySmConditon['or_country_id'] = 0;
            if(isset($sm_codeArr) && !empty($sm_codeArr)){
                $countrySmConditon['sm_code_arr'] = $sm_codeArr;
            }
            $map = Service_SmCountryMap::getByCondition($countrySmConditon, array(
                            'country_id',
                            'sm_code',
                            'warehouse_id',
            ), 0, 0, 'sm_code', 'sm_code');
            $arr['ship_type'] = $map;            
            $cache->setOption('caching',TRUE);
            $cache->setOption('lifetime',86400);
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
    	}
    
    	return $arr;
    }
    /**
     * @author william-fan
     * @todo 运输方式和国家对应关系
     */
    public static function getOrderShipTypeCountryMap($operation = 0)
    {
        $cacheName = 'order_sm_country_map';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove($cacheName);
        }
        if (!$arr = $cache->load($cacheName)) {
            $country = self::getCountry();
            $arr = array();
            $smCondition = array(
            		'sm_status'=>'1',
            );
            $smArr = self::getShippingMethod();
            if(!empty($smArr)){
            	$sm_codeArr = array();
            	foreach($smArr as $key=>$value){
            		if($value['sm_status']=='1'){
            			$sm_codeArr[] = $value['sm_code'];
            		}
            	}
            }//print_r($sm_codeArr);
            foreach ($country as $k => $v) {
            	$countrySmConditon['country_id'] =  $v['country_id'];
            	$countrySmConditon['or_country_id'] = 0;
            	if(isset($sm_codeArr) && !empty($sm_codeArr)){
            		$countrySmConditon['sm_code_arr'] = $sm_codeArr;
            	}
                $map = Service_SmCountryMap::getByCondition($countrySmConditon, array(
                    'country_id',
                    'sm_code',
                    'warehouse_id',
                ), 0, 0, 'sm_code', 'sm_code');
                if(!empty($map)){
                    foreach($map as $k2=>$v2){
                        if($v2['sm_code']!=""){
                            $smRow = Service_ShippingMethod::getByField($v2['sm_code'],'sm_code',array('sm_name_cn','sm_channel','sm_status'));
                            if($smRow['sm_status']=='1'){
                                $map[$k2]['sm_name_cn'] = $smRow['sm_name_cn'];
                                $map[$k2]['sm_channel'] = $smRow['sm_channel'];
                            }else{
                                unset($map[$k2]);
                            }
                        }
                    }
                }
                $v['ship_type'] = $map;
                if(!empty($map)){
                    $arr[$v['country_id']] = $v;
                }
            }
            $cache->setOption('caching',TRUE);
            $cache->setOption('lifetime',24 * 3600);
            $cache->save($arr, $cacheName);
        }

        return $arr;
    }
    /**
     * @author william-fan
     * @todo 得到产品信息
     */
    public static function getProduct($productId, $customerId=0,$operation = 0)
    {
    	$cacheName = 'product__' . $productId;
    	$subDir = 'product';
    	$directoryLevel = 1;
    	$cache = Ec::cache($subDir, $directoryLevel);
    	if ($operation == 1) {
    		$isRemove = $cache->remove($cacheName);
    	}
    	if (!$result = $cache->load($cacheName)) {
    		$result = Service_Product::getProductAllInfo($productId,$customerId);
    		$cache->setLifetime(24 * 3600); // 设置时间，为空则永久
    		$cache->save($result, $cacheName);
    	}
    
    	return $result;
    }
    /**
     * @author william-fan
     * @todo 得到订单的其它信息
     */
    public static function getOrderElseInfo($ordersCode, $operation = 0)
    {
    	$cacheName = 'order__' . $ordersCode;
    	$cache = Ec::cache('order', 1);
    	if ($operation == 1) {
    		$isRemove = $cache->remove($cacheName);
    	}
    	if (!$order = $cache->load($cacheName)) {
    		$order = Service_Orders::getByField($ordersCode, 'order_code');
    		$customer = Service_Customer::getByField($order['customer_code'],'customer_code');
    		$order['currency_code'] = $customer['customer_currency'];//默认货币
    		$reCondition = array(
    			'order_code'=>$ordersCode,
    		);
    		$addressList=Service_OrderAddressBook::getByCondition($reCondition);
    		$orderAddress = array(); //收件人
    		$orderSendAddress = array(); //发件人
    		foreach($addressList as $addressRow) {
    			if($addressRow['oab_type']=='0') $orderAddress = $addressRow;
    			else if($addressRow['oab_type']=='1') $orderSendAddress = $addressRow;
    		}
    		
    		$orderAddress = Service_OrderAddressBook::getByField($ordersCode, 'order_code');//收件人信息
    		$con = array(
    				'order_code' => $ordersCode
    		);
    		//print_r($con);
    		$orderProduct = Service_OrderProduct::getByCondition($con, "*");
    		/* echo '<pre>';
    		print_r($orderProduct);
    		echo '</pre>'; */
    		foreach ($orderProduct as $key => $p) {
    
    			//$product = Common_DataCache::getProduct($p['product_id'],$order['customer_id']); // 缓存中获取
                $product = Service_Product::getProductAllInfo($p['product_id'],$order['customer_id']);
    			$p['product_sku'] = $product['product_sku'];
    
    			$p['product_title_en'] = !empty($p['product_title_en']) ? $p['product_title_en'] : $product['product_title_en']; //英文描述
    			$p['product_title'] = !empty($p['product_title']) ? $p['product_title'] : $product['product_title']; //中文描述
    			$p['product_weight'] = !empty($p['product_weight']) ? $p['product_weight'] : $product['product_weight']; //产品重量
    
    			$p['category_name'] = $product['category_name'];
    			$orderProduct[$key] = $p;
    		}
    
    		$orderUniqueProducts = array();
    		foreach($orderProduct as $v){//提取所有产品（判断有无组合产品）
    			$product = Common_DataCache::getProduct($v['product_id']); // 缓存中获取
    			if($product['product_type']==1){//组合产品
    				$con = array('product_id'=>$product['product_id']);
    				$productCombine = Service_ProductCombineRelation::getByCondition($con,"*");
    				foreach($productCombine as $sub){
    					$subProduct = Common_DataCache::getProduct($sub['pcr_product_id']);
    
    					if(isset($orderUniqueProducts[$sub['pcr_product_id']])){
    						$orderUniqueProducts[$sub['pcr_product_id']]['op_quantity'] += $sub['pcr_quantity']*$v['op_quantity'];
    					}else{
    						$orderUniqueProducts[$sub['pcr_product_id']] = array(
    								'orders_code'=>$ordersCode,
    								'product_id'=>$subProduct['product_id'],
    								'product_title'=>$subProduct['product_title'],
    								'product_title_cn'=>$subProduct['product_title_cn'],
    								'product_sku'=>$subProduct['product_sku'],
    								'product_barcode'=>$subProduct['product_barcode'],
    								'customer_id'=>$subProduct['customer_id'],
    								'op_quantity'=>$sub['pcr_quantity']*$v['op_quantity'],
    								'op_weight'=>$subProduct['product_weight'],
    								'op_unit_price'=>$subProduct['product_declared_value'],
    						);
    					}
    				}
    
    			}else{
    				if(isset($orderUniqueProducts[$v['product_id']])){
    					$orderUniqueProducts[$v['product_id']]['op_quantity'] +=$v['op_quantity'];
    				}else{
    					$orderUniqueProducts[$v['product_id']] = array(
    							'orders_code' => $ordersCode,
    							'product_id' => $product['product_id'],
    							'product_sku' => $product['product_sku'],
    							'product_title'=>$product['product_title'],
    							'product_title_cn'=>$product['product_title_cn'],
    							'product_barcode'=>$product['product_barcode'],
    							'customer_id'=>$product['customer_id'],
    							'op_quantity' => $v['op_quantity'],
    							'op_weight' => $product['product_weight'],
    							'op_unit_price' => $product['product_declared_value'],
    					);
    				}
    			}
    		}
    		//             print_r($orderUniqueProducts);exit;
    		$productUnique = $orderUniqueProducts;//唯一产品
    
    		$warehouse = Common_DataCache::getWarehouse($order['warehouse_id']);
    		//$order['warehouse_name'] = $warehouse['warehouse_name'];
    
    		$country = Common_DataCache::getCountry(false,$orderAddress['oab_country_id']);
    		/* echo '<pre>';
    		print_r($country);
    		echo '</pre>'; */
    		$order['country_name'] = $country['country_name']?$country['country_name']:'';
    		$order['oa_country_code'] = $country['country_code']?$country['country_code']:'';
    		$order['oa_country_name'] = $country['country_name_en']?$country['country_name_en']:'';
    		
    		$allorderType = Service_Orders::getorderType();
    		$order['order_type_title'] = $allorderType[$order['order_type']];
    		$order['order_type_title'] = $allorderType[$order['order_type']];
    
    		$order['order_product'] = $orderProduct;
    		$order['order_product_unique'] = $productUnique;
    		$order['addressSender'] = $orderSendAddress;
    		$order = array_merge($order, $orderAddress);
    
    		$cache->setLifetime(24 * 3600); // 设置时间，为空则永久
    		$cache->save($order, $cacheName);
    	}
    
    	return $order;
    }
    
    /**
     * @author william-fan
     * @todo 用于获取业务状态表数据
     */
    public static function getBusinessStatus($table,$column,$operation = 0,$simple=0,$lang='zh_CN'){
        $cacheName = $table.$column;
        $cache = Ec::cache('data'.$table.$column);
        if ($operation == 1) {
            $cache->remove($cacheName);
        }
        if (!$result = $cache->load($cacheName)) {
            $condition = array(
                'bussiness_table'=>$table,
                'bussiness_column'=>$column,
            );
            $businessStatus = Service_BussinessStatus::getByCondition($condition, '*');
            //print_r($businessStatus);
            $business = array();
            if(!empty($businessStatus)){
                foreach($businessStatus as $k=>$v){
                    $business[$v['bussiness_value']] = $v;
                }
            }
            $cache->setLifetime(24 * 3600);
            $cache->save($business, $cacheName);
            if($simple==0){
               return Common_EtpCommon::customerStatus($business,$lang);
            }else{
                return $business;
            }
        }
        if($simple==0){
            return Common_EtpCommon::customerStatus($result,$lang);
        }else{
            return $result;
        }
    }
    /* @todo:从business_status表获取状态
     * @param string $table 表名
     * @param string $column 列名
     * @param string $display 是否显示
     * @param string $sort 排序
     */
    public static function getBusinessStatusMap( $table, $column, $display = 1, $map = false, $sort = 'asc', $operation = 0) {
        if( empty( $table ) || empty( $column ) ) {
            return array();
        }
        $cacheName = 'business_status_map_'.$table.'_'.$column;
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if (!$arr = $cache->load( $cacheName )) {
            $arr = Service_BussinessStatus::getByCondition(
                array(
                    'bussiness_table'       => $table,
                    'bussiness_column'      => $column,
                ),
                '*', 0, 0, 'bussiness_sort '.$sort
            );
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }

        $tmpDisplay = array();
        if(  $display !== '' || !empty( $display ) ){
            $tmpDisplay = is_array( $display ) ? $display : array( $display );
        }

        $status = array();
        if( !empty( $tmpDisplay ) ) {
            foreach( $arr as $value ) {
                if( in_array( $value['bussiness_is_display'], $tmpDisplay) ) {
                    if( $map ) {
                        $status[ $value['bussiness_value'] ] = $value;
                    } else {
                        $status[] = $value;
                    }
                }
            }
        } else if( $map ) {
            foreach( $arr as $value ) {
                $status[ $value['bussiness_value'] ] = $value;
            }
        } else {
            $status = $arr;
        }
        return $status;
    }

    /**
     * [getPlateform 获取交易平台]
     *
     * @param  integer $sm_id     [description]
     * @param  integer $operation [description]
     *
     * @return [type]             [description]
     */
    public static function getPlateform($plate_code = '', $operation = 0)
    {
        $cacheName = 'plateform';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove($cacheName);
        }
        $arr = array();
        if (!$arr = $cache->load($cacheName)) {
            $result = Service_Plateform::getAll();
            foreach ($result as $row) {
                if($row['status']=='1'){
                    $arr[$row['plate_code']] = $row['plate_code'].'-'.$row['plate_name'];
                }
            }
            // 设置时间，为空则永久
            $cache->setLifetime(24 * 3600); 
            $cache->save($arr, $cacheName);
        }
        if ($plate_code) {
            return isset($arr[$plate_code]) ? $arr[$plate_code] : array();
        }
        return $arr;
    }

    /**
     * @author
     * @todo 用于获取进出口港口
     */
    public static function getIEPort( $operation = 0 ){
        $cacheName = 'ie_port';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if (!$arr = $cache->load( $cacheName )) {
            $iePortRows = Service_IePort::getByCondition();
            foreach( $iePortRows as $value ) {
                $arr[ $value['ie_port'] ] = $value;
            }
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }

        return $arr;
    }

    /**
     * @author
     * @todo 用于获取业务类型
     */
    public static function getFormType( $operation = 0,$isDisplay = '' ){
        $cacheName = 'form_type';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if (!$arr = $cache->load( $cacheName )) {
            $formTypeRows = Service_FormType::getByCondition( array( 'is_display' => $isDisplay ) );
            foreach( $formTypeRows as $value ) {
                $arr[ $value['form_type'] ] = $value;
            }
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }
        $temp = array();
        if( $isDisplay !== '') {
            foreach( $arr as $key => $value) {
                if( $value['is_display'] == $isDisplay ) {
                    $temp[ $key ] = $value;
                }
            }
        } else {
            $temp = $arr;
        }
        return $temp;
    }

    /**
     * @author
     * @todo 用于获取监管方式
     */
    public static function getTradeMode( $operation = 0,$isDisplay = '' ){
        $cacheName = 'trade_mode';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if (!$arr = $cache->load( $cacheName )) {
            $tradeModeRows = Service_TradeMode::getByCondition( );
            foreach( $tradeModeRows as $value ) {
                $arr[ $value['trade_mode'] ] = $value;
            }
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }
        $temp = array();
        if( $isDisplay === '') {
            $temp = $arr;
        } else {
            foreach( $arr as $key =>  $value ) {
                if( $value['is_display'] == $isDisplay ) {
                    $temp[ $key ] = $value;
                }
            }
        }
        return $temp;
    }

    /**
     * @author
     * @todo 用于获取进出港口运输方式
     */
    public static function getTrafMode( $operation = 0,$isDisplay = '' ){
        $cacheName = 'traf_mode';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if (!$arr = $cache->load( $cacheName )) {
            $tradeModeRows = Service_TrafMode::getByCondition( );
            foreach( $tradeModeRows as $value ) {
                $arr[ $value['traf_mode'] ] = $value;
            }
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }
        $temp = array();
        if( $isDisplay === '') {
            $temp = $arr;
        } else {
            foreach( $arr as $key =>  $value ) {
                if( $value['is_display'] == $isDisplay ) {
                    $temp[ $key ] = $value;
                }
            }
        }
        return $temp;
    }

    /**
     * @author
     * @todo 获取证件类型
     */
    public static function getIdCardType( $status = 'ON', $display = 1, $map = false, $sort = 'asc', $operation = 0 ){
        $cacheName = 'id_card_type';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if( $status != 'ON' || $status != 'OFF') {
            $status = 'ON';
        }
        if (!$arr = $cache->load( $cacheName )) {
            $cardType = Service_PaJzbIdCardInfo::getByCondition( array(), '*', 0, 0, 'sort '.$sort);
            foreach( $cardType as $value ) {
                $arr[ $value['id_card_no'] ] = $value;
            }
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }
        $tmpDisplay = array();
        if(  $display !== '' || !empty( $display ) ){
            $tmpDisplay = is_array( $display ) ? $display : array( $display );
        }

        $tmpType = array();
        if( !empty( $tmpDisplay ) ) {
            foreach( $arr as $value ) {
                if( in_array( $value['is_display'], $tmpDisplay) && $status == $value['status'] ) {
                    if( $map ) {
                        $tmpType[ $value['id_card_no'] ] = $value;
                    } else {
                        $tmpType[] = $value;
                    }
                }
            }
        } else {
            foreach( $arr as $value ) {
                if( $status == $value['status'] ) {
                    if( $map ) {
                        $tmpType[ $value['id_card_no'] ] = $value;
                    } else {
                        $tmpType[] = $value;
                    }
                }

            }
        }
        return $tmpType;
    }

    /**
     * @author
     * @todo 用于获取ETP API相关参数值
     * @param int $operation 是否清除缓存
     */
    public static function getEtpApiParam( $operation = 0, $map = true  ){
        $cacheName = 'api_param';
        $cache = Ec::cache();
        if ($operation == 1) {
            $isRemove = $cache->remove( $cacheName );
        }
        if (!$arr = $cache->load( $cacheName )) {
            $arr = Service_Config::getByCondition( array( 'plate_code' => 1 ) );
            $cache->setLifetime(24 * 3600); // 设置时间，为空则永久
            $cache->save($arr, $cacheName);
        }
        $tmp = array();
        if( $map ) {
            foreach( $arr as $key => $value ) {
                $tmp[ $value['config_attribute'] ] = $value;
            }
        } else {
            $tmp = $arr;
        }
        return $tmp;
    }
}