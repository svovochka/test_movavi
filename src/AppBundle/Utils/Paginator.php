<?php

namespace AppBundle\Utils;

use Doctrine\ORM\QueryBuilder;

class Paginator
{

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var integer
     */
    protected $defaultPerPage = 20;

    /**
     * @var integer
     */
    protected $maxPerPage = 100;

    /**
     * @var integer
     */
    protected $currentPage = 1;

    /**
     * @var integer
     */
    protected $perPage = 20;

    /**
     * @var integer
     */
    protected $totalRecords = 0;

    /**
     * @var integer
     */
    protected $offset;

    /**
     * Paginator constructor.
     *
     * @param QueryBuilder $queryBuilder
     * @param int $perPage
     * @param int $currentPage
     */
    public function __construct($queryBuilder, $perPage, $currentPage)
    {
        $this->queryBuilder = $queryBuilder;
        $this->setPerPage($perPage);
        $this->setCurrentPage($currentPage);
    }

    /**
     * Fetch paginated data
     * @return array
     */
    public function paginate()
    {

        //Clone builder
        $clonedQueryBuilder = clone $this->queryBuilder;

        //Count collection
        $this->totalRecords = (int) $clonedQueryBuilder
            ->select('count(DISTINCT e.id)')
            ->orderBy('e.id')
            ->getQuery()
            ->getSingleScalarResult();

        //Recalculate current page
        $currentPage = min($this->currentPage, $this->getTotalPages());
        $this->currentPage = $currentPage > 0 ? $currentPage : 1;

        //Fetch query result
        return $this->queryBuilder
            ->groupBy('e.id')
            ->setFirstResult($this->getOffset())
            ->setMaxResults($this->getPerPage())
            ->getQuery()
            ->getResult();
    }

    /**
     * Get calculated total pages number
     * @return int
     */
    public function getTotalPages()
    {
        return ceil($this->totalRecords / $this->perPage);
    }

    /**
     * Get calculated offset
     * @return int
     */
    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * Get perPage value
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Set perPage value
     *
     * @param int $perPage
     *
     * @return Paginator
     */
    public function setPerPage($perPage)
    {
        if ($perPage <= 0) {
            $this->perPage = $this->defaultPerPage;
        } elseif ($perPage > $this->maxPerPage) {
            $this->perPage = $this->maxPerPage;
        } else {
            $this->perPage = (int) $perPage;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getDefaultPerPage()
    {
        return $this->defaultPerPage;
    }

    /**
     * @param int $defaultPerPage
     *
     * @return Paginator
     * return $this
     */
    public function setDefaultPerPage($defaultPerPage)
    {
        $this->defaultPerPage = $defaultPerPage;
    }

    /**
     * @return int
     */
    public function getMaxPerPage()
    {
        return $this->maxPerPage;
    }

    /**
     * @param int $maxPerPage
     *
     * @return Paginator
     */
    public function setMaxPerPage($maxPerPage)
    {
        $this->maxPerPage = $maxPerPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    /**
     * Get current page
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set currentPage value
     *
     * @param int $currentPage
     *
     * @return Paginator
     */
    public function setCurrentPage($currentPage)
    {
        if ($currentPage <= 0) {
            $currentPage = 1;
        }
        $this->currentPage = $currentPage;

        return $this;
    }

}