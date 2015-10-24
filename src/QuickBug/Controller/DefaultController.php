<?php

namespace QuickBug\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\ControllerProviderInterface;
use QuickBug\Kernel;
use QuickBug\Common\Paginator;

class DefaultController
{

    public function indexAction(Application $app, Request $request)
    {
        $conditions = array(
            'status' => 'todo',
            'latest' => 'createdTime'
        );

        $orderBy = array('createdTime', 'DESC');
        $issues = $this->getIssueService()->searchIssues($conditions, $orderBy, 0, 100);

        return $app['twig']->render('default/index.html.twig', array(
            'issueStatus' => 'todo',
            'issues' => $issues
        ));
    }

    public function issueAction(Application $app, Request $request, $id)
    {
        $issue = $this->getIssueService()->getIssue($id);
        return $app['twig']->render('default/issue-show-modal.html.twig', array(
            'issue' => $issue
        ));
    }

    public function issuesAction(Application $app, Request $request, $status)
    {
        $searchData = $request->query->all();
        $conditions = $this->processerSearchData($searchData);

        $conditions['status'] = $status;

        $orderBy = array('createdTime', 'DESC');
        $issues = $this->getIssueService()->searchIssues($conditions, $orderBy, 0, 100);

        return $app['twig']->render('default/issue-grid.html.twig', array(
            'issueStatus' => $status,
            'issues' => $issues,
            'sortMode' => !empty($searchData['sortMode'])?$searchData['sortMode']:'time'
        ));
    }

    private function processerSearchData($searchData){
        $conditions = array();

        if(!empty($searchData['onlyMe']) && $searchData['onlyMe'] == 'true'){
            $conditions['doUserId'] = 1;
        }else{
            unset($conditions['doUserId']);
        }

        if(!empty($searchData['sort'])){
            $conditions['latest'] = $searchData['sort'];
        }else{
            unset($conditions['latest']);
        }

        if(!empty($searchData['sortMode']) && $searchData['sortMode'] == 'priority'){
            $conditions['orderByPriority'] = true;
        }

        return $conditions;
    }

    protected function getIssueService()
    {
        return $this->kernel()->service('IssueService');
    }

    protected function kernel()
    {
        return Kernel::instance();
    }
}