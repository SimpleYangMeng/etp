<?php
class Common_Validator{

    public static function formValidator($validateArray) {
        $error = array();
        foreach($validateArray as $validate){

            $name = $validate['name'];
            $value = $validate['value'];
            if(trim($value) === ''&& in_array('require',$validate['regex'])){
                $error[] = "$name 为必填项";
                continue;
            }elseif(trim($value) === ''){
                continue;
            }
            foreach($validate['regex'] as $regex){
                switch(true){
                    case (substr($regex,0,6) == 'length'):
                        $length = str_replace('length[','',$regex);
                        $length = str_replace(']','',$length);
                        $lengthArray = explode(",", $length);
                        $valueLength = strlen($value);

                        if($valueLength < $lengthArray[0] || $valueLength > $lengthArray[1]){
                            $error[] = "$name 内容长度在 {$lengthArray[0]} - {$lengthArray[1]} 个字符之间";
                            break 2;
                        }
                        continue 2;
                    case (substr($regex,0,7) == 'number['):   //范围两边值可取
                        $length = str_replace('number[','',$regex);
                        $length = str_replace(']','',$length);
                        $lengthArray = explode(",", $length);
                        if($value < $lengthArray[0] || $value > $lengthArray[1]){
                            $error[] = "$name 大小在 {$lengthArray[0]} - {$lengthArray[1]}";
                            break 2;
                        }
                        continue 2;
                    case (substr($regex,0,7) == 'number('):   //范围两边值不可取
                        $length = str_replace('number(','',$regex);
                        $length = str_replace(')','',$length);
                        $lengthArray = explode(",", $length);
                        if($value <= $lengthArray[0] || $value >= $lengthArray[1]){
                            $error[] = "$name 大小在 {$lengthArray[0]} - {$lengthArray[1]} ";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'email'):   //email验证
                        if(!eregi("^[a-zA-Z0-9_\.-]+\@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$",$value)){
                            $error[] = "$name 内容不是合法的邮箱地址";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'integer'): //正整数（可为0）
                        if(!preg_match("/^\d+$/",$value)){
                            $error[] = "$name 内容不是一个正整数";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'positive1'):   //正数（不可为0）
                        if(!preg_match("/^[1-9]\d*(.\d+)*$|^0.\d*[1-9]+\d*$/",$value)){
                            $error[] = "$name 内容不是一个正数";
                            break 2;
                        }
                        continue 2;

                    case ($regex == 'positive'):   //正数（可为0）
                        if(!preg_match("/^\d*(.\d*)$/",$value)){
                            $error[] = "$name 内容不是一个正数";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'telephone'): //电话号码

                        continue 2;
                    case ($regex == 'noCharacter'): //不能是汉字
                        if(preg_match("/[\x{4e00}-\x{9fa5}]+/u",$value)){
                            $error[] = "$name 内容中不能有汉字";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'english');
                    	if(!preg_match('/^[A-Za-z]+$/', $value)) {
                    		$error[] = $name . "内容中只为英文";
                    		break 2;
                    	}
                    	continue 2;
                    case ($regex == 'chinese'):   //含有中文
                    	$low=chr(0xa1);
						$high=chr(0xff);
                    	if (!preg_match("/[$low-$high]/",$value)){
                            $error[] = "$name "."内容必须含有中文字符";
                            break 2;
                        }
                        continue 2;
                    case (substr($regex,0,5) == 'equal'): //两值相比较
                        $compareValue = str_replace('equal[','',$regex);
                        $compareValue = str_replace(']','',$compareValue);
                        $compareArray = explode(",", $compareValue);
                        if ($compareArray[0] != $compareArray[1]) {
                            $error[] = "$name 不一致";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'specialCharDesc'):
                        $specialChar = array("tools","sample","Electronics","Gift"," Personal gift","Personal sample");
                        if(in_array(trim($value),$specialChar)){
                            $error[] = "$name "."内容不能有特殊字符";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'onlyNumber'):

                        if(preg_match("/^\d+$/",$value)){
                            $error[] = "$name "."内容不能只有数字";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'charNumber'):
                        if(!preg_match("/^[\s\n0-9a-zA-Z]+$/",$value)){
                            $error[] = "$name ".I18n::getInstance()->translate('1306097');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'charOnly'):
                        if(!preg_match("/^[\s\na-zA-Z]+$/",$value)){
                            $error[] = "$name ".I18n::getInstance()->translate('1306096');
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'msn_qq'):
                        if (!preg_match("/^[0-9]{5,15}$|^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/",$value)){
                            $error[] = "$name 内容错误";
                            break 2;
                        }
                        continue 2;
                    case ($regex == 'us_zip'):
                        if (!preg_match("/^[0-9]{5}(\-[0-9]{4}){0,1}+$/",$value)){
                            $error[] = "$name "."美国邮编为5位数字";
                            break 2;
                        }
                        continue 2;
                     case ($regex == 'euexp_char'):
						if(!self::eu_encode($value)){
							$error[] = "$name "."不充许包含英文字母与数字以外的字母";
                            break 2;
                    	 }
                        continue 2;
                     case (substr($regex,0,4) == 'max['):
                        $compareValue = str_replace('max[','',$regex);
                        $compareValue = str_replace(']','',$compareValue);
                        $compareArray = explode(",", $compareValue);
                        if ($compareArray[0] < $value) {
                            $error[] = "$name 最大限制为".$compareArray[0].$compareArray[1];
                            break 2;
                        }
                        continue 2;
                     case ($regex == 'en_char'):
                        if (self::selectEnchar($value)){
                            $error[] = "$name 必须带有英文字符";
                            break 2;
                        }
                        continue 2;
                    case ( $regex == 'isValidIdType' ):
                        if( false === self::isValidIdType( $value ) ) {
                            $error[] = "证件类型不对";
                            break 2;
                        }
                        continue 2;
                    case ( $regex == 'cnMobilePhone' ):
                        if( false === self::cnMobilePhone( $value ) ) {
                            $error[] = "手机号码不正确";
                            break 2;
                        }
                        continue 2;
                }
            }
        }
        return $error;
    }
    public static function selectEnchar($str){
        $length = strlen($str);
        $i=0;
        while($i<$length){
            $ascii = ord($str[$i]);
            if($ascii<=122 && $ascii>=65)
            {
                return false;
            }
            $i++;
        }
        return true;
    }
	public static function Validator($validate){
		$name = $validate['name'];
		$error = '';
        $value = $validate['value'];
        if(trim($value) === ''&& in_array('require',$validate['regex'])){
            $error = "$name 为必填项";
			return $error;
        }elseif(trim($value) === ''){
               return ;
         }
		foreach($validate['regex'] as $regex){
                switch(true){
                    case (substr($regex,0,6) == 'length'):
                        $length = str_replace('length[','',$regex);
                        $length = str_replace(']','',$length);
                        $lengthArray = explode(",", $length);
                        $valueLength = strlen($value);
                        if($valueLength < $lengthArray[0] || $valueLength > $lengthArray[1]){
                            $error = "$name 内容长度范围为".""." {$lengthArray[0]} "."—"." {$lengthArray[1]} ";
                            break 2;
                        }
                        continue 1;
                    case (substr($regex,0,7) == 'number['):   //范围两边值可取
                        $length = str_replace('number[','',$regex);
                        $length = str_replace(']','',$length);
                        $lengthArray = explode(",", $length);
                        if($value < $lengthArray[0] || $value > $lengthArray[1]){
                            $error = "$name "."大小范围为"." {$lengthArray[0]} "."—"." {$lengthArray[1]}";
                            break 2;
                        }
                        continue 1;
                    case (substr($regex,0,7) == 'number('):   //范围两边值不可取
                        $length = str_replace('number(','',$regex);
                        $length = str_replace(')','',$length);
                        $lengthArray = explode(",", $length);
                        if($value <= $lengthArray[0] || $value >= $lengthArray[1]){
                            $error = "$name "."大小范围为"." {$lengthArray[0]} "."—"." {$lengthArray[1]} ";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'email'):   //email验证
                        if(!eregi("^[a-zA-Z0-9_\.-]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$",$value)){
                            $error = "$name "."内容不是正确的电子邮箱地址";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'integer'): //正整数（可为0）
                        if(!preg_match("/^\d+$/",$value)){
                            $error = "$name "."内容不是一个正数";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'positive'):   //正数（可为0）
                        if(!preg_match("/^\d*(.\d*)$/",$value)){
                            $error = "$name "."内容不是一个正数";
                            break 2;
                        }
                        continue 1;

                    case ($regex == 'positive1'):   //正数（不可为0）
                        if(!preg_match("/^[1-9]\d*(.\d+)*$|^0.\d*[1-9]+\d*$/",$value)){
                            $error = "$name 内容不是一个不为0的正数";
                            break 2;
                        }
                        continue 1;

                    case ($regex == 'telephone'): //电话号码

                        continue 1;
                    case ($regex == 'cn_char'):   //中文字符
                    	$low=chr(0xa1);
						$high=chr(0xff);
                    	if (preg_match("/[$low-$high]/",$value)){
                            $error = "$name "."内容不能有中文字符";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'charNumber'):
                        if(!preg_match("/^[\s\n0-9a-zA-Z]+$/",$value)){
                            $error = "$name ".I18n::getInstance()->translate('1306097');
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'charOnly'):
                        if(!preg_match("/^[\s\na-zA-Z]+$/",$value)){
                            $error = "$name ".I18n::getInstance()->translate('1306096');
                            break 2;
                        }
                        continue 1;
                    case (substr($regex,0,5) == 'equal'): //两值相比较
                        $compareValue = str_replace('equal[','',$regex);
                        $compareValue = str_replace(']','',$compareValue);
                        $compareArray = explode(",", $compareValue);
                        if ($compareArray[0] != $compareArray[1]) {
                            $error = "$name "."与前一个值比较不相等";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'specialCharDesc'):
                        $specialChar = array("tools","sample","Electronics","Gift"," Personal gift","Personal sample");
                        if(in_array(trim($value),$specialChar)){
                            $error = "$name "."内容不能有特殊字符";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'onlyNumber'):

                        if(preg_match("/^\d+$/",$value)){
                            $error = "$name "."内容不能只有数字";
                            break 2;
                        }
                        continue 1;
                    case ($regex == 'msn_qq'):
                        if (!preg_match("/^[0-9]{5,15}$|^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/",$value)){
                            $error = "$name "."内容不是正确的MSN或QQ";
                            break 2;
                        }
                        continue 1;
					case ($regex == 'us_zip'):
                        if (!preg_match("/^[0-9]{5}(\-[0-9]{4}){0,1}+$/",$value)){
                            $error = "$name "."美国邮编为5位数字";
                            break 2;
                        }
//                        continue 1;
						if(!self::eu_encode($value)){
                    	 	$error = "$name "."不充许包含英文字母与数字以外的字母";
                            break 2;
                    	 }
                        continue 1;
                     case (substr($regex,0,4) == 'max['):
                        $compareValue = str_replace('max[','',$regex);
                        $compareValue = str_replace(']','',$compareValue);
                        $compareArray = explode(",", $compareValue);
                        if ($compareArray[0] < $value) {
                            $error = "$name 最大限制为".$compareArray[0].$compareArray[1];
                            break 2;
                        }
                        continue 1;
                     case ($regex == 'numeric'):
                        if (!is_numeric($value)) {
                            $error = "$name 必须为数字";
                            break 2;
                        }
                        continue 1;
                     case ($regex == 'en_char'):
                        if (self::selectEnchar($value)){
                            $error = "$name 必须带有英文字符";
                            break 2;
                        }
                        continue 1;
                }
            }
            return $error;
	}



	public static function eu_encode($str){
		 $length = strlen($str);
			$i=0;
			$nStr = '';
			while($i<$length){
				$ascii = ord($str[$i]);
				if($ascii>126){
					return false;
				}
				$i++;
			}
			return true;
	 }

    public static function isValidIdType( $idType ) {
        if( $idType === '' )
            return false;

        $rows = Service_PaJzbIdCardInfo::getByCondition(
            array(
                'id_card_no' => $idType,
            )
        );
        if( empty( $rows ) )
            return false;
        else
            return true;
    }

    public static function cnMobilePhone( $value ) {
        return preg_match('/^1[34578]\d{9}$/',$value) ? true : false;
    }

}