<?php

namespace AppBundle\Controller\Admin\Categories;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends BaseController
{
    /**
     * @Route("/admin/categories/create", name="admin_categories_create")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $model = new Category();

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

        return $this->render('@Admin/categories/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}