<?php

namespace AppBundle\Controller\Admin\Categories;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteController extends BaseController
{
    /**
     * @Route("/admin/categories/{id}/delete", name="admin_categories_delete", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function indexAction($id, Request $request)
    {
        $category = $this->getRepository(Category::class)->find($id);

        if (!$category || $category->getLvl() == 0) {
            throw new NotFoundHttpException();
        }

        $this->getEntityManager()->remove($category);
        $this->getEntityManager()->flush();

        return $this->redirectToRoute('admin_categories');
    }
}