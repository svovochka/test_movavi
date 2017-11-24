<?php

namespace AppBundle\Controller\Admin\Comments;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends BaseController
{
    /**
     * @Route("/admin/comments/create", name="admin_comments_create")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/comments/create.html.twig');
    }
}