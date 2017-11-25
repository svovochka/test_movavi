<?php

namespace AppBundle\Controller\Admin\Categories;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ListController extends BaseController
{
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function indexAction(Request $request)
    {
        $queryBuilder = $this->getRepository(Category::class)->createQueryBuilder('e')
            ->andWhere('e.lvl!=0')
            ->addOrderBy('e.lft', 'ASC');

        $categories = $queryBuilder->getQuery()->getResult();

        return $this->render('@Admin/categories/list.html.twig', [
            'categories' => $categories
        ]);
    }
}