<?php

namespace AppBundle\Controller\Admin\Comments;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteController extends BaseController
{
    /**
     * @Route("/admin/comments/{id}/delete", name="admin_comments_delete", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function indexAction($id, Request $request)
    {
        $comment = $this->getRepository(Comment::class)->find($id);

        if (!$comment) {
            throw new NotFoundHttpException();
        }

        $this->getEntityManager()->remove($comment);
        $this->getEntityManager()->flush();

        return $this->redirectToRoute('admin_comments');
    }
}