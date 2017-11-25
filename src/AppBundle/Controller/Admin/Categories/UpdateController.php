<?php

namespace AppBundle\Controller\Admin\Categories;

use AppBundle\Entity\Category;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateController extends BaseController
{
    /**
     * @Route("/admin/categories/{id}/update", name="admin_categories_update", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function indexAction($id, Request $request)
    {
        $model = $this->getRepository(Category::class)->find($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $queryBuilder = $this->getRepository(Category::class)->createQueryBuilder('e')
            ->addOrderBy('e.lft', 'ASC');
        $categories = $queryBuilder->getQuery()->getResult();

        $form = $this->createFormBuilder($model)
            ->add('title', TextType::class, ['label' => 'Title'])
            ->add('category', EntityType::class, [
                    'class' => Category::class,
                    'choice_label' => 'title',
                    'choices' => $categories,
                    'label' => 'Category']
            )
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $model = $form->getData();
            $this->getEntityManager()->persist($model);
            $this->getEntityManager()->flush();

            return $this->redirectToRoute('admin_categories');
        }

        // replace this example code with whatever you need
        return $this->render('@Admin/categories/update.html.twig', [
            'article' => $model,
            'form' => $form->createView()
        ]);
    }
}