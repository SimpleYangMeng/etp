<?php
class Common_Barcode
{
	public static function barcode($text){
		 
		$config = new Zend_Config(array(
			'barcode'        => 'code128',
			'barcodeParams'  => array('text' => $text),
			'renderer'       => "image",
			'rendererParams' => array('imageType' => 'gif'),
		));


		$renderer = Zend_Barcode::factory($config);
		return $renderer->render();
	}
	
  /**
   * 增设对条形码的某些选项的设置
   * 
   * @author Daniel Chen
   */
  public static function render($text, $option = array()) {
    if(isset($option['codeType'])&&$option['codeType']=='code39'){
         $barcode = new Zend_Barcode_Object_Code39();
    }else{
     $barcode = new Zend_Barcode_Object_Code128();
    }
    $barcode->setText($text);

    $renderer = new Zend_Barcode_Renderer_Image();
    $renderer->setImageType('gif');

    // 是否显示条形码内容
    if (isset($option['show'])) {
      $barcode->setDrawText($option['show']);
    }

    // 不显示条形码内容时，条形码高度与输出图像高度一致
    if (!$barcode->getDrawText() && isset($option['height'])) {
      $barcode->setBarHeight($option['height']);
      $renderer->setHeight($option['height']);
    }

    // 输出图像宽度，不能小于条形码宽度
    if (isset($option['width'])) {
      $renderer->setWidth($option['width']);
    }

    // 条形码图像输出格式：png、jpg、jpeg、gif
    if (isset($option['type'])) {
      $renderer->setImageType($option['type']);
    }

    $renderer->setBarcode($barcode);
    $renderer->render();
  }
}