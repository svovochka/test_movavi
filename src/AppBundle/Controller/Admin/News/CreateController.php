<?php

namespace AppBundle\Controller\Admin\News;

use AppBundle\Entity\Category;
use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends BaseController
{
    /**
     * @Route("/admin/news/create", name="admin_news_create")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $model = new News();

        $queryBuilder = $this->getRepository(Category::class)->createQueryBuilder('e')
            ->andWhere('e.lvl!=0')
            ->addOrderBy('e.lft', 'ASC');
        $categories = $queryBuilder->getQuery()->getResult();

        $form = $this->createFormBuilder($model)
            ->add('title', TextType::class, ['label' => 'Title'])
            ->add('summary', TextareaType::class, ['label' => 'Summary'])
            ->add('text', TextareaType::class, ['label' => 'Text'])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Publish',
                'required'=>false
            ])
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

            return $this->redirectToRoute('admin_news');
        }

        return $this->render('@Admin/news/create.html.twig', [
            'form' => $form->createView()
        ]);

    }
}