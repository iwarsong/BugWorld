<?php


namespace QuickBug\Dao;


class IssueDao extends BaseDao
{
    protected $table = 'issue';

    public function searchCountIssues($conditions)
    {
        $this->filterStartLimit($start, $limit);
        $builder = $this->_createSearchQueryBuilder($conditions)
            ->select('COUNT(id)')
            ;

        return $builder->execute()->fetchColumn(0);
    }

    public function searchIssues($conditions, $orderBy, $start, $limit)
    {
        $this->filterStartLimit($start, $limit);
        $builder = $this->_createSearchQueryBuilder($conditions)
            ->select('*')
            ->orderBy($orderBy[0], $orderBy[1])
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ;

        return $builder->execute()->fetchAll() ? : array();
    }

    protected function _createSearchQueryBuilder($conditions)
    {
        $builder = $this->createDynamicQueryBuilder($conditions)
            ->from($this->table, 'issue')
            ->andWhere('id = :id')
            ->andWhere('status = :status')
            ->andWhere('doUserId = :doUserId')
            ->andWhere('checkUserId = :checkUserId')
            ->andWhere('createdUserId = :createdUserId')
            ->andWhere('projectId = :projectId')
            ;

        return $builder;
    }
}