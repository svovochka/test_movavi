<?php

namespace AppBundle\Controller\Admin\Categories;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class UpdateController extends BaseController
{
    /**
     * @Route("/admin/categories/{id}/update", name="admin_categories_update", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function indexAction($id, Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/categories/update.html.twig');
    }
}