<?php

namespace AppBundle\Controller\Admin\News;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @Route("/admin/news", name="admin_news")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Admin/news/list.html.twig');
    }
}