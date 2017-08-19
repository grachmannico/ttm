<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . "vendor\dompdf\dompdf\autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator
{

    public function generate($html, $filename = '', $stream = true, $paper = 'A4', $orientation = "")
    {
        $dompdf = new DOMPDF();
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->set_option('defaultFont', 'Helvetica');
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}
