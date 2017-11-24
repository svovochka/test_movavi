<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\News;
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
        $direction = $request->query->get('direction') ?? 'DESC';

        $queryBuilder = $this->getRepository(News::class)->createQueryBuilder('e');
        $queryBuilder->andWhere('e.isActive=1');
        $queryBuilder->addOrderBy('e.createdAt', $direction);

        //Configure paginator
        $page = $request->query->get('page');
        $perPage = 3;
        $paginator = $this->getPaginator($queryBuilder, $perPage, $page);

        //Find collection
        $recentNews = $paginator->paginate();

        return $this->render('@Frontend/default.html.twig', [
            'news' => $recentNews,
            'paginator' => $paginator,
            'direction' => $direction
        ]);
    }
}
