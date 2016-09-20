<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/phpqrcode/phpqrcode.php';

class Qr extends CI_Controller {
    function __construct() {
        $this->ci = & get_instance();
       
    }
    public function save($name,$text){
  //   	$errorCorrectionLevel = 'L';//容错级别   
		// $matrixPointSize = 6;//生成图片大小
		$level = 'QR_ECLEVEL_L';
		$size = 3;
		$margin = 3;
		$saveandprint = true;
        QRcode::png($text, APPPATH.'cache/qrcode/'.$name.'.png', $level, $size, $margin, $saveandprint);  
    }

}
