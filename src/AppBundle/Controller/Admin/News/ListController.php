<?php

namespace AppBundle\Controller\Admin\News;

use AppBundle\Entity\News;
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

        $queryBuilder = $this->getRepository(News::class)->createQueryBuilder('e');
        $queryBuilder->addOrderBy('e.createdAt', 'DESC');

        //Configure paginator
        $page = $request->query->get('page');
        $perPage = 20;
        $paginator = $this->getPaginator($queryBuilder, $perPage, $page);

        //Find collection
        $articles = $paginator->paginate();

        return $this->render('@Admin/news/list.html.twig', [
            'articles' => $articles,
            'paginator' => $paginator
        ]);
    }
}