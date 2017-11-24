<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends BaseController
{
    /**
     * @Route("/news/{slug}", name="frontend_news", requirements={"slug": "[a-z\-]+"})
     */
    public function indexAction($slug, Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Frontend/news.html.twig');
    }
}