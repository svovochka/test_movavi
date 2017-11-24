<?php

namespace AppBundle\Controller\Admin\Categories;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends BaseController
{
    /**
     * @Route("/admin/categories/create", name="admin_categories_create")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/categories/create.html.twig');
    }
}