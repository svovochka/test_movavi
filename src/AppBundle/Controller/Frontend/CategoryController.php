<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController
{
    /**
     * @Route("/category/{slug}", name="frontend_category", requirements={"slug": "[a-z\-]+"})
     */
    public function indexAction($slug, Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Frontend/category.html.twig');
    }
}
