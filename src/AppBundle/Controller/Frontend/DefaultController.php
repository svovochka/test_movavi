<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="frontend_default")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@Frontend/default.html.twig');
    }
}
