<?php
require_once 'Zend/Loader/Autoloader/Resource.php';
class Ec_Loader_AutoModules extends Zend_Loader_Autoloader_Resource
{

    public function __construct()
    {
        $options = array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH . '/models',
        );
        parent::__construct($options);
        $this->initMyResourceTypes();
    }


    public function initMyResourceTypes()
    {
        $basePath = $this->getBasePath();
        $this->addResourceTypes(
            array(
                'Table' => array(
                    'namespace' => 'Table',
                    'path' => 'Table',
                ),
                'DbTable' => array(
                    'namespace' => 'DbTable',
                    'path' => 'DbTable',
                ),
                'Service' => array(
                    'namespace' => 'Service',
                    'path' => 'Service',
                ),
                'Common' => array(
                    'namespace' => 'Common',
                    'path' => 'Common',
                ),
            	'Api' => array(
            		'namespace' => 'Api',
            		'path' => 'Api',
            	)
            ));
        $this->setDefaultResourceType('model');
    }

}
