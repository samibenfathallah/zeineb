<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of BlocController
 *
 * @author sawssen
 */
class MenuController extends Controller {

    public function menuAction() {
//        return $this->render('AdminBundle:Default:bloc.html.twig');
        $menus = $this->getDoctrine()->getRepository(Menu::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:menu_liste.html.twig', array('menus' => $menus));
    }

    public function addmenuAction() {
        return $this->render('AdminBundle:Default:formaddmenu.html.twig');
    }

    public function editmenuAction() {
        $menu = $this->getDoctrine()->getRepository(Menu::class)->findOneById($_GET['id']);
        return $this->render('AdminBundle:Default:formeditmenu.html.twig', array('menu' => $menu));
    }

    public function validemenuAction() {

        // $m=$_POST['menu'];
        //$_POST = array();
        
                $em = $this->getDoctrine()->getManager();
                //echo $m;
                //var_dump($_POST);die;
                $menu = new Menu();
                $menu->setDescription($_POST['menu']);
                $menu->setUrl($_POST['url']);




                $em->persist($menu);
                $em->flush();
            
        //$_POST['menu']= '';
        //$m=$_POST['menu'];
        $menus = $this->getDoctrine()->getRepository(Menu::class)->findAll();
        /* print_r($services);
          die(); */
        // unset($_POST);
        // return $this->render('AdminBundle:Default:menu_liste.html.twig', array('menus' => $menus, 'valideadd' => '1'));
        return $this->redirectToRoute('admin_menu', array('valideadd' => '1'));
    }

    public function valideeditmenuAction() {
        $em = $this->getDoctrine()->getManager();
        $menu = $this->getDoctrine()->getRepository(Menu::class)->findOneById($_POST['idmenu']);
        $menu->setDescription($_POST['menu']);
        $menu->setUrl($_POST['url']);




        $em->persist($menu);
        $em->flush();
        $menus = $this->getDoctrine()->getRepository(Menu::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:menu_liste.html.twig', array('menus' => $menus, 'valideedit' => '1'));
    }

    public function deletemenuAction() {

        $em = $this->getDoctrine()->getManager();
        $menu = $this->getDoctrine()->getRepository(Menu::class)->findOneById($_GET['id']);
        $em->remove($menu);
        $em->flush();

        $menus = $this->getDoctrine()->getRepository(Menu::class)->findAll();
        /* print_r($services);
          die(); */
        //return $this->render('AdminBundle:Default:menu_liste.html.twig', array('menus' => $menus, 'validesupp' => '1'));
        return $this->redirectToRoute('admin_menu', array('validesupp' => '1'));
    }

    public function printAction() {
        $pdf = new \FPDF();

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);

        $pdf->SetTextColor(0, 0, 0);

        $pdf->Multicell(190, 5, "Hello World!", '', 'C', false);

        $menus = $this->getDoctrine()->getRepository(Menu::class)->findAll();
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


        return new Response($pdf->Output(), 200, array('Content-Type' => 'application/pdf'));
        //return $this->render('doc.pdf');
    }

}
