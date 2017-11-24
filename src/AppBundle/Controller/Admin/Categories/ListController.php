<?php

namespace AppBundle\Controller\Admin\Categories;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/categories/list.html.twig');
    }
}