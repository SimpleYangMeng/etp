<?php
class Common_TransError{
	public static function Transerror($errors){
		$transError = array();
		if($errors){
			foreach ($errors as $key=>$value){
				$transError[] = array('errorMessage'=>$value);
			}
		}
		return $transError;
	}
}