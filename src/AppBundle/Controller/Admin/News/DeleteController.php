<?php

namespace AppBundle\Controller\Admin\News;

use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteController extends BaseController
{
    /**
     * @Route("/admin/news/{id}/delete", name="admin_news_delete", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function indexAction($id, Request $request)
    {
        $article = $this->getRepository(News::class)->find($id);

        if (!$article) {
            throw new NotFoundHttpException();
        }

        $this->getEntityManager()->remove($article);
        $this->getEntityManager()->flush();

        return $this->redirectToRoute('admin_news');
    }
}