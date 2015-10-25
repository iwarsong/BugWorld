<?php


namespace QuickBug\Service;


class IssueService extends BaseService
{
    public function addIssue($issue)
    {
        return $this->getIssueDao()->addIssue($issue);
    }

    public function getIssue($id)
    {
        return $this->getIssueDao()->getIssue($id);
    }

    public function searchIssues($conditions, $orderBy, $start, $limit)
    {
        $orderBy = $this->convertOrderByByConditions($conditions);
        return $this->getIssueDao()->searchIssues($conditions, $orderBy, $start, $limit);
    }

    public function searchCountIssues($conditions)
    {
        return $this->getIssueDao()->searchCountIssues($conditions);
    }

    public function updateIssue($issueId, $fields)
    {
        return $this->getIssueDao()->updateIssue($issueId, $fields);
    }

    protected function getIssueDao()
    {
        return $this->kernel()->dao('IssueDao');
    }

    protected function convertOrderByByConditions($conditions)
    {
        $orderBy = array();
        if(!empty($conditions['latest'])){
            $orderBy =  array($conditions['latest'], 'DESC');
        }elseif(!empty($conditions['orderByPriority'])){
            $orderBy = array('priority', 'DESC');
        }

        return $orderBy;

    }
}