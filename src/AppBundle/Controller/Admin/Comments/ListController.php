<?php

namespace AppBundle\Controller\Admin\Comments;

use AppBundle\Entity\Comment;
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
        $queryBuilder = $this->getRepository(Comment::class)->createQueryBuilder('e');
        $queryBuilder->addOrderBy('e.createdAt', 'DESC');

        //Configure paginator
        $page = $request->query->get('page');
        $perPage = 20;
        $paginator = $this->getPaginator($queryBuilder, $perPage, $page);

        //Find collection
        $comments = $paginator->paginate();

        return $this->render('@Admin/comments/list.html.twig', [
            'comments' => $comments,
            'paginator' => $paginator
        ]);
    }
}