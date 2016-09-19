<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/excel/PHPExcel.php';

class Excel extends CI_Controller {
    function __construct() {
        $this->ci = & get_instance();
       
    }
    public function down($fileName,$titleArr=array(),$data=array()){
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                     ->setLastModifiedBy("Maarten Balliauw")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Test result file");


        // Add title
        $col = 0;
        foreach ($titleArr as $k => $v) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k.'1', $v);
            
            $index = 2;
            for($i=0;$i<count($data);$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k.$index, $data[$i][$col]);
                $index = $index+1;
            }
            $col = $col+1;
        }
        // foreach ($data as $key => $value) {
        //     $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k.$index+2, $value[$index]);

        // }
   
        // Miscellaneous glyphs, UTF-8
       
        
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('报销列表');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$fileName);
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}
