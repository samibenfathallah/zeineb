<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

/**
 * Description of PrintController
 *
 * @author sawssen
 */
class PrintController extends Controller {

    //put your code here
    public function printAction() {
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(190, 5, 'Bonjour', '', 'C', false);
        return new Reponse($pdf->Output(), 200, array('Content-Type' => 'application/pdf'));
    }

}
