<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Entity\Images;
use AdminBundle\Entity\Menu;
use AdminBundle\Entity\Menu2;
class DefaultController extends Controller
{
    public function indexAction()
    {
        $images = $this->getDoctrine()->getRepository(Images::class)->ListeImagesSlider();
        $menus = $this->getDoctrine()->getRepository(Menu::class)->ListeMenu();
        $menus1 = $this->getDoctrine()->getRepository(Menu2::class)->ListeMenu();
        return $this->render('HomeBundle:Default:index.html.twig', array('images' => $images, 'menus' => $menus , 'menus1' => $menus1));
    }
    
        
    
}
