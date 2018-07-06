<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Menu2;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Description of BlocController
 *
 * @author sawssen
 */
class Menu2Controller extends Controller {

    public function menuAction() {
//        return $this->render('AdminBundle:Default:bloc.html.twig');
        $menus = $this->getDoctrine()->getRepository(Menu2::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:menu2_liste.html.twig', array('menus' => $menus));
    }

    public function addmenuAction() {
        return $this->render('AdminBundle:Default:formaddmenu2.html.twig');
    }

    public function editmenuAction() {
        $menu = $this->getDoctrine()->getRepository(Menu2::class)->findOneById($_GET['id']);
        return $this->render('AdminBundle:Default:formeditmenu2.html.twig', array('menu' => $menu));
    }

    public function validemenuAction() {

        // $m=$_POST['menu'];
        //$_POST = array();
        
                $em = $this->getDoctrine()->getManager();
                //echo $m;
                //var_dump($_POST);die;
                $menu = new Menu2();
                $menu->setDescription($_POST['menu']);
                $menu->setUrl($_POST['url']);




                $em->persist($menu);
                $em->flush();
            
        //$_POST['menu']= '';
        //$m=$_POST['menu'];
        $menus = $this->getDoctrine()->getRepository(Menu2::class)->findAll();
        /* print_r($services);
          die(); */
        // unset($_POST);
        // return $this->render('AdminBundle:Default:menu_liste.html.twig', array('menus' => $menus, 'valideadd' => '1'));
        return $this->redirectToRoute('admin_menu2', array('valideadd' => '1'));
    }

    public function valideeditmenuAction() {
        $em = $this->getDoctrine()->getManager();
        $menu = $this->getDoctrine()->getRepository(Menu2::class)->findOneById($_POST['idmenu']);
        $menu->setDescription($_POST['menu']);
        $menu->setUrl($_POST['url']);




        $em->persist($menu);
        $em->flush();
        $menus = $this->getDoctrine()->getRepository(Menu2::class)->findAll();
        /* print_r($services);
          die(); */
        return $this->render('AdminBundle:Default:menu2_liste.html.twig', array('menus' => $menus, 'valideedit' => '1'));
    }

    public function deletemenuAction() {

        $em = $this->getDoctrine()->getManager();
        $menu = $this->getDoctrine()->getRepository(Menu2::class)->findOneById($_GET['id']);
        $em->remove($menu);
        $em->flush();

        $menus = $this->getDoctrine()->getRepository(Menu2::class)->findAll();
        /* print_r($services);
          die(); */
        //return $this->render('AdminBundle:Default:menu_liste.html.twig', array('menus' => $menus, 'validesupp' => '1'));
        return $this->redirectToRoute('admin_menu2', array('validesupp' => '1'));
    }

    

}
