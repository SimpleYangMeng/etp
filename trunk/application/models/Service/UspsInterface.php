<?php

/**
 * luffy丶大叔 
 * <><><><><><><><><><><><><>有妹子加微信不哦！~<><><><><><><><><><><><><><><><>
 * @Author: luffy丶大叔 
 * @Z 2015-8-25 15:25:41
 * @email luffy00789@126.com
 * @encoding UTF-8
*/

class Service_UspsInterface {
    //正式
    const WEB_SERVICE   =   'http://intl.sf-express.com/CBTA/ws/sfexpressService?wsdl';
    const WEB_VERIFY    =   '429C2CA0EAC341D6F1744AAD2B22C816'; 
    const CUSTOMER_CODE  = '7550100431';
 //测试
    // const WEB_SERVICE   =   'http://ibu-ibse.sit.sf-express.com:1091/CBTA/ws/sfexpressService?wsdl';
   //  const WEB_VERIFY    =   'DBC0833D5E081D384230528172E3BDE8'; 
    // const CUSTOMER_CODE  = '7550075493';
    
    private $data   =   array();  
    private $shippingMethod =   array(
            'BH-USPS'=>array(
                'express_type'=>'A9',
                'j_address'     =>  '4/F,Block 5,Qianhaiwan Free Trade Port Area,No.53 Linhai Rd.'
            ),
            'BH-DPD'=>array(
                'express_type'=>'A3',
                'j_address'     =>  '4/F,Block 5,Qianhaiwan Free Trade Port Area,No.53 Linhai Rd.'
            ),
           'PNLG'=>array(
                'express_type'=>'E2',
                'j_address'     =>  '4/F,Block 5,Qianhaiwan Free Trade Port Area,No.53 Linhai Rd.'
            ),
           'PNLN'=>array(
                'express_type'=>'E1',
                'j_address'     =>  '4/F,Block 5,Qianhaiwan Free Trade Port Area,No.53 Linhai Rd.'
            )
        );
public function __construct() {
    if(!file_exists(APPLICATION_PATH.'/../data/usps/')){
        mkdir(APPLICATION_PATH.'/../data/usps/',0777);
    }
}
     

    /**
     * @author luffy丶大叔
     * @todo 验证订单
     * @param type $orderCode
     */
    public function orderValidate($orderCode) {
        #订单
        $this->data['order'] = Service_Orders::getByField($orderCode,'order_code',"*");  
        if(!$this->shippingMethodValidate($this->data['order']['sm_code'])){
            throw new Exception("订单号【{$orderCode}】运输渠道不属于顺风！");
        }
        #订单收货地址
        $orderReceiveAddress = Service_OrderAddressBook::getByCondition(array('order_code'=>$orderCode,'oab_type'=>'0'),"*");
        $this->data['orderAddress'] = $orderReceiveAddress[0];
        $reCountry = Service_Country::getByField($this->data['orderAddress']['oab_country_id'],"country_id",array('country_code'));
        if(!$reCountry){
            throw new Exception("订单【{$orderCode}】收货国家代码不存在！");
        }  
        $this->data['orderAddress']['country_code'] =   $reCountry['country_code'];
        if($this->data['orderAddress']['oab_street_address2']!=""){
            $this->data['orderAddress']['oab_street_address1'] = $this->data['orderAddress']['oab_street_address1']." ".$this->data['orderAddress']['oab_street_address2'];
        }
        #订单产品
        $this->data['orderProduct'] = Service_OrderProduct::getByCondition(array('order_code'=>$orderCode),"*");        
    }
    /**
     * @author luffy大叔
     * @todo 发送订单
     * @return [type]
     */
    public function sendOrder() {
        $xmlArray   =   array(
            '@attributes' => array(
                'service' => 'OrderService',
                'lang' => 'zh-CN'
            ),
            'Head'  => self::CUSTOMER_CODE
        );
        $grossWt = 0;
       foreach($this->data['orderProduct'] AS $value){
           $p = Service_Product::getByField($value['product_id'],"product_id",array('product_title' , 'product_title_en' , 'hs_code' , 'pu_code' , 'product_weight'));
           $xmlArray['Body']['Order']['Cargo'][]['@attributes'] =   array(
            'name'=>$p['product_title'],
            'hscode'=>$p['hs_code'],
            'ename'=>$value['product_title_en'], 
            'unit'=>'PCE', 
            'count'=>$value['op_quantity'], 
            'amount'=>$value['op_purpose_declared_value'], 
//            'weight'=>$p['product_weight'] * $value['op_quantity']
            );
           $grossWt += $p['product_weight'] * $value['op_quantity'];
       }     
      

        $shippingMethod = $this->shippingMethodValidate($this->data['order']['sm_code']);
        $xmlArray['Body']['Order']['@attributes']  =   array(
            'orderid' => $this->data['order']['order_code'],
            'express_type'=> $shippingMethod['express_type'],
            'j_company'=>  'Globex eServices Limited',
            'j_contact'=>'Carina',
            'j_tel'=>'0755-21629099',
            'j_mobile'=>'18676724516',
            'j_address'=>$shippingMethod['j_address'],
            'd_contact'=>  $this->data['orderAddress']['oab_firstname'],
            'd_tel'=>$this->data['orderAddress']['oab_phone'],
            'd_mobile'=>$this->data['orderAddress']['oab_cell_phone'] ,
            'd_address'=>$this->data['orderAddress']['oab_street_address1'],
            'parcel_quantity'=>$this->data['order']['parcel_quantity'],
            'j_province'=>'Guangdong',
            'j_city'=>'Shenzhen',
            'd_province'=>html_entity_decode($this->data['orderAddress']['oab_state']),
            'd_city'=>html_entity_decode($this->data['orderAddress']['oab_city']),
            'j_country'=>'CN',
            'j_post_code'=>'518000',
            'd_country'=>$this->data['orderAddress']['country_code'], 
            'd_post_code'=>$this->data['orderAddress']['oab_postcode'], 
            'cargo_total_weight'=> $grossWt,
            'operate_flag'  =>  1 , 
            'd_email'   =>  $this->data['orderAddress']['oab_email'],
            'returnsign'=>'Y'
        );
        $xml    =   $this->array2xml($xmlArray , 'Request');
        file_put_contents(APPLICATION_PATH.'/../data/usps/'.$this->data['order']['order_code'].'.xml' , $xml);
        $this->initial();
        // 
        return $this->soap('sfexpressService', $xml);
    }
    /**
     * @author luffy大叔
     * @todo 提交确认发货
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function submitOrder($orderCode , $refTrackingNumber){
        //OrderConfirmService
        $xmlArray   =   array(
            '@attributes' => array(
                'service' => 'OrderConfirmService',
                'lang' => 'zh-CN'
            ),
            'Head'  => self::CUSTOMER_CODE,
            'Body'=>array(
                'OrderConfirm'=>array(
                    '@attributes'=>array(
                        'orderid'=>$orderCode,
                        'mailno'=>$refTrackingNumber,
                        'dealtype'  =>  1
                        )
                    )
                )
        );
        $xml    =   $this->array2xml($xmlArray , 'Request');
        return $this->soap('sfexpressService', $xml);
    }
    /**
     * @author luffy大叔
     * @todo 获取标签调用顺风接口
     * @param  [type]
     * @param  string
     * @return [type]
     */
    public function getLabel($orderCode , $refTrackingNumber = ''){
        $xmlArray   =   array(
            '@attributes' => array(
                'service' => 'OrderLabelPrintService',
                'lang' => 'zh-CN'
            ),
            'Head'  => self::CUSTOMER_CODE,
            'Body'=>array(
                'OrderLabelPrint'=>array(
                    '@attributes'=>array(
                        'orderid'=>$orderCode,
                        'mailno'=>$refTrackingNumber
                        )
                    )
                )
        );

        $xml    =   $this->array2xml($xmlArray , 'Request');
        return $this->soap('sfexpressService', $xml);
    }

    public function getOrderInfo($orderCode){
        //OrderConfirmService
        $xmlArray   =   array(
            '@attributes' => array(
                'service' => 'OrderSearchService',
                'lang' => 'zh-CN'
            ),
            'Head'  => self::CUSTOMER_CODE,
            'Body'=>array(
                'OrderSearch'=>array(
                    '@attributes'=>array(
                        'orderid'=>$orderCode                    
                        )
                    )
                )
        );
        $xml    =   $this->array2xml($xmlArray , 'Request');
        return $this->soap('sfexpressService', $xml);
    }

    /**
     * @author luffy 大叔
     * @todo 不调用接口生成标签 
     * @return [type]
     */
    public function buildLabelBarcode($orderCode){        
        $barcode = new Code128();
        $barcode->setData($orderCode);
        // 只能打印 17个字符以内的条码。如果要打印17个或者以上的字符请用draw(false)
        $barcode->setDimensions(312 , 47)->setQuality(100)->enableHumanText(false)->draw(false);
        $barcode->output();
    }

    /**
     * @author luufy 大叔
     */
    private function initial(){
        $this->data = array();        
    }
    /**
     * @author luffy丶大叔
     * @todo soap方法
     * @param type $operation
     * @param type $xml
     * @return type
     */
    private function soap($operation , $xml) {
        $client = new SoapClient(self::WEB_SERVICE, array("trace" => true, "connection_timeout" => 200));
        $resource   =   $client->$operation($xml , $this->_md5($xml.self::WEB_VERIFY));
        return $this->returnXMLAnalysis($resource);
    }
    
    /**
     * @author luffy丶大叔
     * @todo 返回xml解析
     * @param type $xmlString
     * @return type
     * @throws Exception
     */
    private function returnXMLAnalysis($xmlString) {
         $xml = simplexml_load_string($xmlString);
         if((string)$xml->Head == 'ERR'){
             $error =   (array)$xml->ERROR;
            throw new Exception("【{$error['@attributes']['code']}】{$error[0]}");
         }
         $body   =   (array) current( (array)$xml->Body );
         return $body['@attributes'];
    }
    
    /**
     * @author luffy丶大叔
     * @todo 验证运输方式 并返回顺风产品代码
     * @param type $smCode
     * @return boolean
     */
    private function shippingMethodValidate($smCode) {
        if(isset($this->shippingMethod[$smCode])){
            return $this->shippingMethod[$smCode];
        }
        return false;
    }
    /**
     * @author luffy丶大叔
     * @todo md5加密并转大写
     * @param type $str
     * @return type
     */
    private function _md5($str){ 
        return base64_encode(strtoupper(md5($str)));
    }
    
    /**
     * @author luffy丶大叔
    * @todo 数组转为xML
    * @param $var 数组
    * @param $type xml的根节点
    * @param $tag
    * @return 返回xml格式
    */
   private function array2xml($var, $type = 'root', $tag = '') {
        $ret = '';
        if (!is_int($type)) {
            if ($tag)
                return array2xml(array($tag => $var), 0, $type);
            else {
                $tag .= $type;
                $type = 0;
            }
        }
        $level = $type;
        $indent = str_repeat("\t", $level);
        if (!is_array($var)) {
            $ret .= $indent . '<' . $tag;
            $var = strval($var);
            if ($var == '') {
                $ret .= ' />';
            } else if (!preg_match('/[^0-9a-zA-Z@\._:\/-]/', $var)) {
                $ret .= '>' . $var . '</' . $tag . '>';
            } else {
                $ret .= "><![CDATA[{$var}]]></{$tag}>";
            }
            $ret .= "\n";
        } else if (!(is_array($var) && count($var) && (array_keys($var) !== range(0, sizeof($var) - 1))) && !empty($var)) {
            foreach ($var as $tmp)
                $ret .= $this->array2xml($tmp, $level, $tag);
        } else {
            $ret .= $indent . '<' . $tag;
            if ($level == 0)
                $ret .= '';
            if (isset($var['@attributes'])) {
                foreach ($var['@attributes'] as $k => $v) {
                    if (!is_array($v)) {
                        $ret .= sprintf(' %s="%s"', $k, $v);
                    }
                }
                unset($var['@attributes']);
            }
            $ret .= ">\n";
            foreach ($var as $key => $val) {
                $ret .= $this->array2xml($val, $level + 1, $key);
            }
            $ret .= "{$indent}</{$tag}>\n";
        }
        return $ret;
    }
}


/**
 * @author luffy大叔
 * @todo 生成顺风条形码
 */
class Code128 extends BarcodeBase
{
    /*
     * @var data - to be set
     */
    private $data = '';
    /*
     * Sub Type encoding
     * @var int (should be a class constant)
     */
    private $type = self::TYPE_AUTO;
    /*
     * This map maps the bar code to the common index. We use the built-in 
     * index that PHP gives us to produce the common index. 
     * @var static array 
     */
    private static $barMap = array(
        11011001100, 11001101100, 11001100110, 10010011000, 10010001100, // 4 (end)
        10001001100, 10011001000, 10011000100, 10001100100, 11001001000, // 9
        11001000100, 11000100100, 10110011100, 10011011100, 10011001110, // 14
        10111001100, 10011101100, 10011100110, 11001110010, 11001011100, // 19
        11001001110, 11011100100, 11001110100, 11101101110, 11101001100, // 24
        11100101100, 11100100110, 11101100100, 11100110100, 11100110010, // 29
        11011011000, 11011000110, 11000110110, 10100011000, 10001011000, // 34
        10001000110, 10110001000, 10001101000, 10001100010, 11010001000, // 39
        11000101000, 11000100010, 10110111000, 10110001110, 10001101110, // 44
        10111011000, 10111000110, 10001110110, 11101110110, 11010001110, // 49
        11000101110, 11011101000, 11011100010, 11011101110, 11101011000, // 54
        11101000110, 11100010110, 11101101000, 11101100010, 11100011010, // 59
        11101111010, 11001000010, 11110001010, 10100110000, 10100001100, // 64
        10010110000, 10010000110, 10000101100, 10000100110, 10110010000, // 69
        10110000100, 10011010000, 10011000010, 10000110100, 10000110010, // 74
        11000010010, 11001010000, 11110111010, 11000010100, 10001111010, // 79
        10100111100, 10010111100, 10010011110, 10111100100, 10011110100, // 84
        10011110010, 11110100100, 11110010100, 11110010010, 11011011110, // 89
        11011110110, 11110110110, 10101111000, 10100011110, 10001011110, // 94
        10111101000, 10111100010, 11110101000, 11110100010, 10111011110, // 99
        10111101110, 11101011110, 11110101110, 11010000100, 11010010000, // 104
        11010011100, 1100011101011 // 106 (last char, also one bit longer)
    );
    /*
     * This map takes the charset from subtype A and PHP will index the array
     * natively to the matching code from the barMap.
     * @var static array 
     */
    private static $mapA = array(
        ' ', '!', '"', '#', '$', '%', '&', "'", '(', ')', // 9 (end)
        '*', '+', ',', '-', '.', '/', '0', '1', '2', '3', // 19
        '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', // 29
        '>', '?', '@', 'A', 'B', 'C', 'D', 'E', 'F', 'G', // 39
        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', // 49
        'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '[', // 59
        '\\', ']', '^', '_', // 63 (We're going into the weird bytes next)
        
        // Hex is a little more concise in this context
        "\x00", "\x01", "\x02", "\x03", "\x04", "\x05", // 69
        "\x06", "\x07", "\x08", "\x09", "\x0A", "\x0B", // 75
        "\x0C", "\x0D", "\x0E", "\x0F", "\x10", "\x11", // 81
        "\x12", "\x13", "\x14", "\x15", "\x16", "\x17", // 87
        "\x18", "\x19", "\x1A", "\x1B", "\x1C", "\x1D", // 93
        "\x1E", "\x1F", // 95
        
        // Now for system codes
        'FNC_3', 'FNC_2', 'SHIFT_B', 'CODE_C', 'CODE_B', // 100
        'FNC_4', 'FNC_1', 'START_A', 'START_B', 'START_C', // 105
        'STOP', // 106
    );
    /*
     * Same idea from MapA applied here to B.
     * @var static array
     */
    private static $mapB = array(
        ' ', '!', '"', '#', '$', '%', '&', "'", '(', ')', // 9 (end)
        '*', '+', ',', '-', '.', '/', '0', '1', '2', '3', // 19
        '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', // 29
        '>', '?', '@', 'A', 'B', 'C', 'D', 'E', 'F', 'G', // 39
        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', // 49
        'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '[', // 59
        '\\', ']', '^', '_', '`', 'a', 'b', 'c', 'd', 'e', // 69
        'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', // 79
        'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', // 89
        'z', '{', '|', '}', '~', "\x7F", // 95
        
        // Now for system codes
        'FNC_3', 'FNC_2', 'SHIFT_A', 'CODE_C', 'FNC_4', // 100
        'CODE_A', 'FNC_1', 'START_A', 'START_B', 'START_C', // 105
        'STOP', // 106
    );
    /*
     * Map C works a little different. The index is the value when the mapping
     * occors. 
     * @var static array
     */
    private static $mapC = array(
        100 => 
        'CODE_B', 'CODE_A', 'FNC_1', 'START_A', 'START_B', 
        'START_C', 'STOP', // 106
    );
    /*
     * Subtypes
     */
    const TYPE_AUTO = 0; // Automatically detect the best code
    const TYPE_A    = 1; // ASCII 00-95 (0-9, A-Z, Control codes, and some special chars)
    const TYPE_B    = 2; // ASCII 32-127 (0-9, A-Z, a-z, special chars)
    const TYPE_C    = 3; // Numbers 00-99 (two digits per code)
    /*
     * Set the data
     *
     * @param mixed data - (int or string) Data to be encoded
     * @return instance of \emberlabs\Barcode\BarcodeInterface
     * @return throws \OverflowException
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    /*
     * Set the subtype
     * Defaults to Autodetect
     * @param int type - Const flag for the type
     */
    public function setSubType($type)
    {
        $this->type = ($type < 1 || $type > 3) ? self::TYPE_AUTO : (int) $type;
    }
    /*
     * Get they key (value of the character)
     * @return int - pattern
     */
    private function getKey($char)
    {
        switch ($this->type)
        {
            case self::TYPE_A:
                return array_search($char, self::$mapA);
            break;
            case self::TYPE_B:
                return array_search($char, self::$mapB);            
            break;
            case self::TYPE_C:
                $charInt = (int) $char;
                if (strlen($char) == 2 && $charInt <= 99 && $charInt >= 0)
                {
                    return $charInt;
                }
                return array_search($char, self::$mapC);
            break;
    
            default:
                $this->resolveSubtype();
                return $this->getKey($char); // recursion!
            break;
        }
    }
    /*
     * Get the bar
     * @return int - pattern
     */
    private function getBar($char)
    {
        $key = $this->getKey($char);
        return self::$barMap[($key !== false) ? $key : 0];
    }
    /*
     * Resolve subtype 
     * @todo - Do some better charset checking and enforcement
     * @return void
     */
    private function resolveSubtype()
    {
        if ($this->type == self::TYPE_AUTO)
        {
            // If it is purely numeric, this is easy
            if (is_numeric($this->data))
            {
                $this->type = self::TYPE_C;
            }
            // Are there only capitals?
            else if(strtoupper($this->data) == $this->data)
            {
                $this->type = self::TYPE_A;
            }
            else
            {
                $this->type = self::TYPE_B;
            }
        }
    }
    /*
     * Get the name of a start char fr te current subtype
     * @return string
     */
    private function getStartChar()
    {
        $this->resolveSubtype();
        switch($this->type)
        {
            case self::TYPE_A: return 'START_A'; break;
            case self::TYPE_B: return 'START_B'; break;
            case self::TYPE_C: return 'START_C'; break;
        }
    }
    /*
     * Draw the image
     *
     * @return void
     */
    public function draw($fixedLength = true)
    {
        $this->resolveSubtype();
        $charAry = str_split($this->data);
        // Calc scaling
        // Bars is in refrence to a single, 1-level bar
        $numBarsRequired = ($this->type != self::TYPE_C) ? (sizeof($charAry) * 11) + 35 : ((sizeof($charAry)/2) * 11) + 35;
        if($fixedLength){
            $pxPerBar =  ($this->x / $numBarsRequired);
        }else{
            $pxPerBar =  (int)($this->x / $numBarsRequired);
        }     

        $currentX = ($this->x - ($numBarsRequired  * $pxPerBar)) / 2;
        ///////////////////////////////////////////
        $pi = $this->x / $this->y;
        //长度
        $this->x =  $pxPerBar * $numBarsRequired;
        //位置
        $currentX = 0;
        // $this->y = $this->x / $pi;
        //////////////////////////////////////////
        if ($pxPerBar < 1)
        {
            throw new LogicException("Not enough space on this barcode for this message, increase the width of the barcode");
        }
        if ($this->type == self::TYPE_C)
        {
            if (sizeof($charAry) % 2)
            {
                array_unshift($charAry, '0');
            }
            $pairs = '';
            $newAry = array();
            foreach($charAry as $k => $char)
            {
                if (($k % 2) == 0 && $k != 0)
                {
                    $newAry[] = $pairs;
                    $pairs = '';
                }
                $pairs .= $char;
            }
            $newAry[] = $pairs;
            $charAry = $newAry;
        }
        // Add the start
        array_unshift($charAry, $this->getStartChar());
        // Checksum collector
        $checkSumCollector = $this->getKey($this->getStartChar());
        $this->img = @imagecreate($this->x, $this->y);
        $white = imagecolorallocate($this->img, 255, 255, 255);
        $black = imagecolorallocate($this->img, 0, 0, 0);
        // Print the code
        foreach($charAry as $k => $char)
        {
            $code = $this->getBar($char);
            $checkSumCollector += $this->getKey($char) * $k; // $k will be 0 for our first
            foreach(str_split((string) $code) as $bit)
            {
                imagefilledrectangle($this->img, $currentX, 0, ($currentX + $pxPerBar), ($this->y - 1), (($bit == '1') ? $black : $white));
                $currentX += $pxPerBar;
            }
        }
        $ending[] = self::$barMap[$checkSumCollector % 103];
        $ending[] = self::$barMap[106]; // STOP.
        foreach($ending as $code)
        {
            foreach(str_split((string) $code) as $bit)
            {
                imagefilledrectangle($this->img, $currentX, 0, ($currentX + $pxPerBar), ($this->y - 1), (($bit == '1') ? $black : $white));
                $currentX += $pxPerBar;
            }
        }
    }
}

/**
 * @author luffy大叔
 * @todo 顺风条形码生成 
 */
abstract class BarcodeBase
{
    /*
     * GD Resource
     * @var resource
     */
    protected $img = null;
    /*
     * @var int x (width)
     */
    protected $x = 0;
    /*
     * @var int y (height)
     */
    protected $y = 0;
    /*
     * Print Human Text?
     * @var bool
     */
    protected $humanText = true;
    /*
     * Quality
     * @var int
     */
    protected $jpgQuality = 85;
    /*
     * (Abstract) Set the data
     *
     * @param mixed data - (int or string) Data to be encoded
     * @return instance of \emberlabs\Barcode\BarcodeInterface
     * @return throws \OverflowException
     */
    abstract public function setData($data);
    /*
     * (Abstract) Draw the image
     *
     * @return void
     */
    abstract public function draw($fixedLength = true);
    /*
     * Set the Dimensions
     *
     * @param int x
     * @param int y
     * @return instance of \emberlabs\Barcode\BarcodeBase
     */
    public function setDimensions($x, $y)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
        return $this;
    }
    /*
     * Set Quality
     * @param int q - jpeg quality 
     * @return instance of \emberlabs\Barcode\BarcodeBase
     */
    public function setQuality($q)
    {
        $this->jpgQuality = (int) $q;
        return $this;
    }
    /*
     * Display human readable text below the code
     * @param boolean enable - Enable the human readable text
     * @return instance of \emberlabs\Barcode\BarcodeBase
     */
    public function enableHumanText($enable = true)
    {
        $this->humanText = (boolean) $enable;
        return $this;
    }
    /*
     * Output Image to the buffer
     *
     * @return void
     */
    public function output($type = 'png')
    {
        switch($type)
        {
            case 'jpg':
            case 'jpeg':
                header("Content-type: image/jpeg");
                imagejpeg($this->img, NULL, $this->jpgQuality);
            break;
            case 'gif':
                header("Content-type: image/gif");
                imagegif($this->img);
            break;
            case 'png':
            default:
                header("Content-type: image/png");
                imagepng($this->img);
            break;
        }
    }
    /*
     * Save Image
     *
     * @param string filename - File to write to (needs to have .png, .gif, or 
     *  .jpg extension)
     * @return void
     * @throws \RuntimeException - If the file could not be written or some 
     *  other I/O error. 
     */
    public function save($filename)
    {
        $type = strtolower(substr(strrchr($filename, '.'), 1));
        switch($type)
        {
            case 'jpg':
            case 'jpeg':
                imagejpeg($this->img, $filename, $this->jpgQuality);
            break;
            case 'gif':
                imagegif($this->img, $filename);
            break;
            case 'png':
                imagepng($this->img, $filename);
            break;
            default:
                throw new \RuntimeException("Could not determine file type.");
            break;
        }
    }
    /*
     * Base64 Encoded 
     * For ouput in-page
     * @return void
     */
    public function base64()
    {
        ob_start();
        $this->output();
        return base64_encode(ob_get_clean());
    }
}
