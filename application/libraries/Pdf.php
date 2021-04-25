<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
 public function __construct()
 {
   parent::__construct();
 } 
 
 
 public function pdf_create($html,$filename)
 {
   $dompdf = new Dompdf();
   $dompdf->load_html($html);
   $dompdf->set_option('isRemoteEnabled', true);
   $dompdf->set_option('isPhpEnabled', true);
   $dompdf->set_paper('A4','portrait');
   $dompdf->render();
   $dompdf->stream($filename.'.pdf',array ("Attachment" => true));
 }


 public function pdf_create_custom($html,$filename)
 {
   $dompdf = new Dompdf();
   $dompdf->load_html($html);
   $dompdf->set_option('isRemoteEnabled', true);
   $dompdf->set_option('isPhpEnabled', true);
   $dompdf->set_paper(array(0,0,1080,1080));
   $dompdf->render();
   $dompdf->stream($filename.'.pdf',array ("Attachment" => true));
 }
 
 
 
 
 
}

?>