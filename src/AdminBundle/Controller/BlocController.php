<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Bloc;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of BlocController
 *
 * @author sawssen
 */
class BlocController extends Controller {

    public function blocAction() {
//        return $this->render('AdminBundle:Default:bloc.html.twig');
        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:bloc.html.twig', array('blocs' => $blocs));
    }

    public function addblocAction() {
        return $this->render('AdminBundle:Default:formaddbloc.html.twig');
    }

    public function editblocAction() {
        $bloc = $this->getDoctrine()->getRepository(Bloc::class)->findOneById($_GET['id']);
        return $this->render('AdminBundle:Default:formeditbloc.html.twig', array('bloc' => $bloc));
    }

    public function valideblocAction() {
        $em = $this->getDoctrine()->getManager();

        // var_dump($_POST);die;
        $bloc = new Bloc();
        $bloc->setDescription($_POST['bloc']);




        $em->persist($bloc);
        $em->flush();


        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:bloc.html.twig', array('blocs' => $blocs, 'valideadd' => '1'));
    }

    public function valideeditblocAction() {
        $em = $this->getDoctrine()->getManager();
        $bloc = $this->getDoctrine()->getRepository(Bloc::class)->findOneById($_POST['idbloc']);
        $bloc->setDescription($_POST['bloc']);




        $em->persist($bloc);
        $em->flush();
        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:bloc.html.twig', array('blocs' => $blocs, 'valideedit' => '1'));
    }

    public function deleteblocAction() {

        $em = $this->getDoctrine()->getManager();
        $bloc = $this->getDoctrine()->getRepository(Bloc::class)->findOneById($_GET['id']);
        $em->remove($bloc);
        $em->flush();

        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:bloc.html.twig', array('blocs' => $blocs, 'validesupp' => '1'));
    }

    public function exportexcelAction() {
        // ask the service for a Excel5

        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        /* print_r($blocs);
          die(); */

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("liuggio")
                ->setLastModifiedBy("Giulio De Donato")
                ->setTitle("Office 2005 XLSX Test Document")
                ->setSubject("Office 2005 XLSX Test Document")
                ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
                ->setKeywords("office 2005 openxml php")
                ->setCategory("Test result file");
        $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Num')
                ->setCellValue('B1', 'Bloc');
        $num = 2;
        //for ($i = 0; $i < count($blocs); $i++) {
        foreach ($blocs as $bloc) {

            /* print_r($res);
              die(); */
            $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue('A' . $num, $num - 1)
                    ->setCellValue('B' . $num, $bloc->getDescription());
            $num++;
        }

        $phpExcelObject->getActiveSheet()->setTitle('Liste des Blocs');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'stream-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    public function returnPDFResponseFromHTML($html) {
        //set_time_limit(30); uncomment this line according to your needs
        // If you are not in a controller, retrieve of some way the service container and then retrieve it
        //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //if you are in a controlller use :
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Our Code World');
        $pdf->SetTitle(('Our Code World Title'));
        $pdf->SetSubject('Our Code World Subject');
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 11, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();

        $filename = 'Liste_blocs';

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->Output($filename . ".pdf", 'I'); // 'I' This will output the PDF as a response directly
    }

    public function exportpdfAction() {
        $tbl = '
<table border="1" cellpadding="2" cellspacing="2">
<thead>
 <tr style="background-color:#FFFF00;color:#0000FF;">
  <td width="30" align="center"><b>A</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
 <tr style="background-color:#FF0000;color:#FFFF00;">
  <td width="30" align="center"><b>B</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="140" align="center"><b>XXXX</b></td>
  <td width="80" align="center"> <b>XXXX</b></td>
  <td width="80" align="center"><b>XXXX</b></td>
  <td width="45" align="center"><b>XXXX</b></td>
 </tr>
</thead>
 <tr>
  <td width="30" align="center">1.</td>
  <td width="140" rowspan="6">XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center" rowspan="3">2.</td>
  <td width="140" rowspan="3">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80">XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="80" rowspan="2" >RRRRRR<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">3.</td>
  <td width="140">XXXX1<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
 <tr>
  <td width="30" align="center">4.</td>
  <td width="140">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td width="80">XXXX<br />XXXX</td>
  <td align="center" width="45">XXXX<br />XXXX</td>
 </tr>
</table>
';
        // You can send the html as you want
        //$html = '<h1>Plain HTML</h1>';
        // but in this case we will render a symfony view !
        // We are in a controller and we can use renderView function which retrieves the html from a view
        // then we send that html to the user.
        //$html = $this->renderView('AdminBundle:Default:bloc.html.twig', array('blocs' => $blocs, 'validesupp' => '1'));
        $html = "<h1 style='color:red'>Liste des Bolcss</h1>"
                . "<table cellspacing='0' border='1' cellpadding='1'><thead><tr> <th style='background-color: gray; text-align: center'>Num</th> <th>Bloc</th></tr></thead><tbody style='border:1px solid red;width:20%;'>";
        $num = 1;
        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();

        foreach ($blocs as $bloc) {


            $html = $html . "<tr><td>" . $num . "</td><td>" . $bloc->getDescription() . "</td></tr>";
            $num++;
        }
        $html = $html . "</tbody></table>";
        $this->returnPDFResponseFromHTML($tbl);
    }

    public function printAction() {
        $pdf = new \FPDF();

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);

        $pdf->SetTextColor(0, 0, 0);

        $pdf->Multicell(190, 5, "Hello World!", '', 'C', false);

        $blocs = $this->getDoctrine()->getRepository(Bloc::class)->findAll();
        //print_r($blocs);
        //die;
        for ($i = 0; $i < count($blocs); $i++) {
            $pdf->Multicell(190, 5, $blocs[$i]->getDescription(), '', 'C', false);
        }

        $header = array("Rubrique", "Nombre");
        $data[0] = array("Déignation", "1");
        $data[1] = array("Divers", "5");
        $data[2] = array("Références début", "10");
        $data[3] = array("Références fin", "20");
        $pdf->FancyTable($header, $data);

        $filename = 'docx';
        // return new Response($pdf->Output($filename . ".pdf", 'I'), 200, array('Content-Type' => 'application/pdf'));
        //$pdf->Output($filename . ".pdf", 'I'); // This will output the PDF as a response directly
        return $this->render('doc.pdf');
    }

}
