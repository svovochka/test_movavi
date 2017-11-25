<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FrontendMenuExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_frontend_menu', [$this, 'getFrontendMenu'], [
                'is_safe' => ['html'],
            ])
        ];
    }

    protected function getDoctrine()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->container->get('doctrine');
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param string $entityClass
     * @param int $id
     *
     * @return mixed
     */
    protected function findEntity($entityClass, $id)
    {
        return $this->getRepository($entityClass)->find($id);
    }

    /**
     * @param $entityClass
     *
     * @return EntityRepository
     */
    protected function getRepository($entityClass)
    {
        return $this->getEntityManager()->getRepository($entityClass);
    }

    public function getFrontendMenu()
    {
        $queryBuilder = $this->getRepository(Category::class)->createQueryBuilder('e')
            //->innerJoin('e.news', 'n')
            //->andWhere('n.isActive=1')
            ->andWhere('e.lvl!=0')
            ->addOrderBy('e.lft', 'ASC');

        $menuItems = $queryBuilder->getQuery()->getResult();

        return $menuItems;
    }
}