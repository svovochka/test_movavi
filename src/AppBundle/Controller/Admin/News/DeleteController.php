<?php

namespace AppBundle\Controller\Admin\News;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends BaseController
{
    /**
     * @Route("/admin/news/{id}/delete", name="admin_news_delete", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function indexAction($id, Request $request)
    {
        // replace this example code with whatever you need
        return $this->redirectToRoute('admin_news');
    }
}