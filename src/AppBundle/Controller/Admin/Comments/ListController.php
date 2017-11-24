<?php

namespace AppBundle\Controller\Admin\Comments;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @Route("/admin/comments", name="admin_comments")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/comments/list.html.twig');
    }
}