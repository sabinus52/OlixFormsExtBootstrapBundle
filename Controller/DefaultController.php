<?php

namespace Olix\FormsExtBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OlixFormsExtBundle:Default:index.html.twig', array('name' => $name));
    }
}
