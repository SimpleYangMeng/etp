<?php
class Common_Customer
{
	// --------------------------------------------------------------------
	public function markCustomCode($code, $length = 4, $prefix = 'E')
	{
		if (empty($code)) {
			return FALSE;
		}
		$val	= $this->_getCurrentNumber($code);
		$val	= str_pad($val, $length, '0', STR_PAD_LEFT);
		return strtoupper($prefix . $val);
	}

	// --------------------------------------------------------------------
	private function _getCurrentNumber($code = '', $initialVal = 88)
	{
		$time		= date('Y-m-d H:i:s');
		$condition	= array(
			'application_code'	=> $code
		);
		$application= Service_Application::getByCondition($condition);
		if (empty($application)) {
			$data	= array(
				'application_code'	=> $code,
				'current_number'	=> $initialVal,
				'app_add_time'		=> $time
			);
			Service_Application::add($data);
		} else {
			//
			$applicationRow = Service_Application::getByFieldLock($application[0]['application_id'], 'application_id');
			if (!empty($applicationRow['current_number'])) {
				$initialVal	= (int)$applicationRow['current_number'] + 1;
			}
			$data	= array(
				'current_number'	=> $initialVal,
				'app_update_time'	=> $time
			);
			Service_Application::update($data, $applicationRow['application_id']);
		}
		return $initialVal;
	}
}