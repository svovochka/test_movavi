<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Category;
use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends BaseController
{
    /**
     * @Route("/category/{slug}", name="frontend_category", requirements={"slug": "[a-z0-9\-]+"})
     */
    public function indexAction($slug, Request $request)
    {
        $category = $this->getRepository(Category::class)->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $direction = $request->query->get('direction') ?? 'DESC';

        $queryBuilder = $this->getRepository(News::class)->createQueryBuilder('e')
            ->innerJoin('e.category', 'c')
            ->andWhere('e.isActive=1')
            ->andWhere('c.lft>=:lft')
            ->andWhere('c.rgt<=:rgt')
            ->setParameter('lft', $category->getLft())
            ->setParameter('rgt', $category->getRgt())
            ->addOrderBy('e.createdAt', $direction);

        //Configure paginator
        $page = $request->query->get('page');
        $perPage = 3;
        $paginator = $this->getPaginator($queryBuilder, $perPage, $page);

        //Find collection
        $categoryNews = $paginator->paginate();

        return $this->render('@Frontend/category.html.twig', [
            'category' => $category,
            'news' => $categoryNews,
            'paginator' => $paginator,
            'direction' => $direction
        ]);
    }
}
