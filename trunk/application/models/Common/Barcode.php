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
   * ������������ĳЩѡ�������
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

    // �Ƿ���ʾ����������
    if (isset($option['show'])) {
      $barcode->setDrawText($option['show']);
    }

    // ����ʾ����������ʱ��������߶������ͼ��߶�һ��
    if (!$barcode->getDrawText() && isset($option['height'])) {
      $barcode->setBarHeight($option['height']);
      $renderer->setHeight($option['height']);
    }

    // ���ͼ���ȣ�����С����������
    if (isset($option['width'])) {
      $renderer->setWidth($option['width']);
    }

    // ������ͼ�������ʽ��png��jpg��jpeg��gif
    if (isset($option['type'])) {
      $renderer->setImageType($option['type']);
    }

    $renderer->setBarcode($barcode);
    $renderer->render();
  }
}