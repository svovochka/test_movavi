<?php

namespace AppBundle\Controller\Admin\Comments;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class UpdateController extends BaseController
{
    /**
     * @Route("/admin/comments/{id}/update", name="admin_comments_update", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function indexAction($id, Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/comments/update.html.twig');
    }
}