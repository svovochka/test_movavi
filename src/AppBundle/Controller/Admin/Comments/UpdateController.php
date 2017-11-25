<?php

namespace AppBundle\Controller\Admin\Comments;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Controller\BaseController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateController extends BaseController
{
    /**
     * @Route("/admin/comments/{id}/update", name="admin_comments_update", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function indexAction($id, Request $request)
    {
        $model = $this->getRepository(Comment::class)->find($id);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        $form = $this->createFormBuilder($model)
            ->add('text', TextareaType::class, ['label' => 'Text'])
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $model = $form->getData();
            $this->getEntityManager()->persist($model);
            $this->getEntityManager()->flush();

            return $this->redirectToRoute('admin_comments');
        }

        return $this->render('@Admin/comments/update.html.twig', [
            'comment' => $model,
            'form' => $form->createView()
        ]);
    }
}