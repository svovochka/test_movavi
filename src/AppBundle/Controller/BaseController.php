<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Paginator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
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

    /**
     * Get maximal per page number
     * @return Paginator
     */
    protected function getPaginator($queryBuilder, $perPage, $currentPage)
    {
        $paginator = new Paginator($queryBuilder, $perPage, $currentPage);
        $paginator->setMaxPerPage($perPage);
        $paginator->setDefaultPerPage($perPage);

        return $paginator;
    }
}
