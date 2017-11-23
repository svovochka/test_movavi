<?php

namespace AppBundle\Controller\Admin\Categories;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UpdateController extends Controller
{
    /**
     * @Route("/admin/categories/{id}/update", name="admin_categories_update", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function indexAction($id, Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }
}