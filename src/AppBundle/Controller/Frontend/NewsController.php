<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Comment;
use AppBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\BaseController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends BaseController
{
    /**
     * @Route("/news/{slug}", name="frontend_news", requirements={"slug": "[a-z0-9\-]+"})
     */
    public function indexAction($slug, Request $request)
    {
        $article = $this->getRepository(News::class)->findOneBy(['slug' => $slug, 'isActive' => 1]);

        if (!$article) {
            throw new NotFoundHttpException();
        }

        //Create comment object
        $comment = new Comment();
        $comment->setNews($article);

        $commentForm = $this->createFormBuilder($comment)
            ->add('text', TextareaType::class)
            ->add('save', SubmitType::class, array('label' => 'Send comment'))
            ->getForm();

        $commentForm->handleRequest($request);

        $successReport = false;
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment = $commentForm->getData();
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush();
            $successReport = true;
        }

        //Get comments
        $queryBuilder = $this->getRepository(Comment::class)->createQueryBuilder('e');
        $queryBuilder->andWhere('e.news=:articleId');
        $queryBuilder->setParameter('articleId', $article->getId());
        $queryBuilder->addOrderBy('e.createdAt', 'DESC');

        //Configure paginator
        $page = $request->query->get('page');
        $perPage = 3;
        $paginator = $this->getPaginator($queryBuilder, $perPage, $page);

        //Find collection
        $comments = $paginator->paginate();

        return $this->render('@Frontend/news.html.twig', [
            'article' => $article,
            'comments' => $comments,
            'paginator' => $paginator,
            'commentForm' => $commentForm->createView(),
            'successReport' => $successReport
        ]);
    }
}