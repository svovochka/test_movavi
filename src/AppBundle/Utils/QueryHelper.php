<?php

namespace AppBundle\Utils;

use Doctrine\ORM\QueryBuilder;

class QueryHelper
{
    const LIKE_ESCAPE = '!';
    const LIKE_STRATEGY_STARTS = 1;
    const LIKE_STRATEGY_ENDS = 2;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var array
     */
    protected $joinedItems = [];

    /**
     * Paginator constructor.
     *
     * @param QueryBuilder $queryBuilder
     */
    public function __construct($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function leftJoin($join, $alias)
    {
        if (!array_key_exists($alias, $this->joinedItems)) {
            $this->joinedItems[$alias] = $join;
            $this->queryBuilder->leftJoin($join, $alias);
        }
    }

    public function innerJoin($join, $alias)
    {
        if (!array_key_exists($alias, $this->joinedItems)) {
            $this->joinedItems[$alias] = $join;
            $this->queryBuilder->innerJoin($join, $alias);
        }
    }

    public function buildOrWhereLikeCondition($field, $paramName)
    {
        return $field . ' LIKE :' . $paramName . " ESCAPE '" . self::LIKE_ESCAPE . "'";
    }

    public function buildGroupOrWhereLikeCondition($fields, $paramName)
    {
        $conditions = [];
        foreach ($fields as $field) {
            $conditions[] = $this->buildOrWhereLikeCondition($field, $paramName);
        }
        return '(' . implode(' OR ', $conditions) . ')';
    }

    public function andWhereLike($field, $paramName)
    {
        if (is_array($field)) {
            $condition = $this->buildGroupOrWhereLikeCondition($field, $paramName);
        } else {
            $condition = $this->buildOrWhereLikeCondition($field, $paramName);
        }
        $this->queryBuilder->andWhere($condition);

        return $this;
    }

    public function orWhereLike($field, $paramName)
    {
        if (is_array($field)) {
            $condition = $this->buildGroupOrWhereLikeCondition($field, $paramName);
        } else {
            $condition = $this->buildOrWhereLikeCondition($field, $paramName);
        }
        $this->queryBuilder->orWhere($condition);

        return $this;
    }

    public function setWhereLikeParam($paramName, $value, $strategy = null)
    {
        if ($strategy == self::LIKE_STRATEGY_STARTS) {
            $value = $this->makeLikeParam($value, '%s%%');
        } elseif ($strategy == self::LIKE_STRATEGY_ENDS) {
            $value = $this->makeLikeParam($value, '%%%s');
        } else {
            $value = $this->makeLikeParam($value);
        }

        $this->queryBuilder->setParameter($paramName, $value);
    }

    public function addSort($field, $direction)
    {
        $path = \explode('_', $field);
        if (count($path) === 1) {
            $this->queryBuilder->addOrderBy('e.' . $field, strtoupper($direction));
        } else {
            $root = 'e';

            while ($part = \array_shift($path)) {
                if (count($path) === 0) {
                    $this->queryBuilder->addOrderBy("{$root}.{$part}", strtoupper($direction));
                } else {
                    $this->leftJoin("{$root}.{$part}", $part);
                    $root = $part;
                }
            }
        }
    }

    protected function makeLikeParam($search, $pattern = '%%%s%%')
    {
        /**
         * Function defined in-line so it doesn't show up for type-hinting on
         * classes that implement this trait.
         *
         * @param string $search
         *
         * @return string
         */
        $sanitizeLikeValue = function ($search) {
            $escapeChar = self::LIKE_ESCAPE;
            $escape = [
                '\\' . $escapeChar,
                '\%',
                '\_',
            ];
            $pattern = sprintf('/([%s])/', implode('', $escape));
            return preg_replace($pattern, $escapeChar . '$0', $search);
        };
        return sprintf($pattern, $sanitizeLikeValue($search));
    }
}