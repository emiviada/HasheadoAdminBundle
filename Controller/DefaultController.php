<?php

namespace Hasheado\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HasheadoAdminBundle:Default:index.html.twig', array('name' => $name));
    }
}
