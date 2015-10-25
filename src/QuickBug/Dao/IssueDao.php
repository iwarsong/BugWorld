<?php


namespace QuickBug\Dao;


class IssueDao extends BaseDao
{
    protected $table = 'issue';

    public function addIssue($issue)
    {
        $affected = $this->db()->insert($this->table, $issue);
        if ($affected <= 0) {
            throw $this->createDaoException('Insert issue error.', 51001);
        }

        return $this->getIssue($this->db()->lastInsertId());
    }

    public function getIssue($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
        return $this->db()->fetchAssoc($sql, array($id)) ?: null;
    }

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

    public function updateIssue($issueId, $fields)
    {
        $this->db()->update($this->table, $fields, array('id' => $issueId));
        return $this->getIssue($issueId);
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