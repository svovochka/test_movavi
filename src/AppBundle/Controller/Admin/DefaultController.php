<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    /**
     * @Route("/admin", name="admin_default")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@Admin/default.html.twig');
    }
}