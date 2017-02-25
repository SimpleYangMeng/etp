<?php

class Default_ViewImageController extends Ec_Controller_DefaultAction 
{    
	public function preDispatch(){
		$this->tplDirectory	= "default/views/default/";
	}

    /**
     * [viewUploadImageAction 返回查看链接地址]
     * @return [type] [description]
     */
    public function viewUploadImageAction ()
    {
        $fileName = $this->_request->getParam('fileName', "");
        $path = APPLICATION_PATH . "/../data/images/" . $fileName;
        if (file_exists($path)) {
            header('Content-Type: image/jpeg');
            echo file_get_contents($path);
        } else {
            header("Location: /images/noimg.jpg");
        }
        exit();
    } 
    /* 查看产品图片 */
    public function viewImageAction ()
    {
        $productId = $this->_request->getParam('id', "");
        if ($productId) {
            $productAttach =Service_ProductAttached::getByField($productId);
            if(empty($productAttach)){
                header("Location: /images/noimg.jpg");exit;
            }
            $path = APPLICATION_PATH."/../data/images/".$productAttach['pa_path'];
			
            //echo $path;exit;
            if ($productAttach['pa_file_type'] == 'img') {
                //header('Content-Type: image/jpeg');
                if(file_exists($path)){
					Service_ProductAttached::update(array('pa_content'=>base64_encode(file_get_contents($path))),$productId);
					echo 1;
                }else{
                    header("Location: /images/noimg.jpg");
                }
            }else{
                header("Location: ".$productAttach['pa_path']);
    
            }
            exit();
        }
    
        header("Location: /images/noimg.jpg");
    }
    
    /* 查看图片 */
    public function viewAttachAction ()
    {
    
        $attachId = $this->_request->getParam('aid', "");
    
        if ($attachId) {
            $productAttach = Service_ProductAttached::getByField($attachId);
            if(empty($productAttach)){
                header("Location: /images/noimg.jpg");exit;
            }
            $path = APPLICATION_PATH."/../data/images/".$productAttach['pa_path'];
            if ($productAttach['pa_file_type'] == 'img') {
                header('Content-Type: image/jpeg');
                if(file_exists($path)){                	
                    echo file_get_contents($path);
                }else{
                    header("Location: /images/noimg.jpg");
                }
            }else{
                header("Location: ".$productAttach['pa_path']);
            }
            exit();
        }
    
        header("Location: /images/noimg.jpg");
    }
    /**
     * @author william-fan
     * @todo 查看图片只掉一张
     */
    public function viewOneAttachAction(){
    	$productId = $this->_request->getParam('productId','');
    	
    	if ($productId) {
    		$productImages = Service_ProductAttached::getByCondition(array('product_id'=>$productId));
    		if(empty($productImages)){
    			header("Location: /images/noimg.jpg");exit;
    		}
    		foreach($productImages as $key=>$value){
    			$path = APPLICATION_PATH."/../data/images/".$value['pa_path'];
    			if ($value['pa_file_type'] == 'img') {
    				header('Content-Type: image/jpeg');
    				if(file_exists($path)){
    					echo file_get_contents($path);
    					break;
    					exit;
    				}
    			}else{
    				header("Location: ".$value['pa_path']);
    			}
    		}

    		exit();
    	}
    	header("Location: /images/noimg.jpg");
    }
    /**
     * @author william-fan
     * @todo 查看图片
     */
    public function viewAllAttachAction(){
    	$attachId = $this->_request->getParam('aid', "");
    	$productId = $this->_request->getParam('productId','');
		$width 	= $this->_request->getParam('width',140);
		$height = $this->_request->getParam('height',140);
		if(!is_numeric($width)){
			$width =140;
		}
		if(!is_numeric($height)){
			$height=140;
		}
    	$maindomain = Zend_Registry::get('maindomian');
    	$maindomain = 'http://'.$maindomain;
    	if($productId!=''){
    		$productImages = Service_ProductAttached::getByCondition(array('product_id'=>$productId));
    		if(!empty($productImages)){
    			foreach ($productImages as $key => $attach) {
    				/* if ($attach['pa_file_type'] == 'img') {
    					$attaches[$key]['url'] = '';
    				} else {
    					$attaches[$key]['url'] = $attach['pa_path'];
    				} */
    				$productImages[$key]['url'] = $maindomain.'/default/product-image/view-attach/aid/'.$attach['pa_id'];
    			}
    		}
    	}else{
    		if($attachId!=''){
    			$productimage=Service_ProductAttached::getByField($attachId);
    			$productimage['url'] = $maindomain.'/default/product-image/view-attach/aid/'.$productimage['pa_id'];
    			$productImages = array($productimage);
    		}
    	}
    	$this->view->productAttr = $productImages;
    	$this->view->height = $height;
    	$this->view->width = $width;
    	//echo $this->tplDirectory . "img.tpl";
    	//var_dump(file_exists($this->tplDirectory . "img.tpl"));
    	echo Ec::renderTpl($this->tplDirectory . "img.tpl", 'layout-img');
    }
}