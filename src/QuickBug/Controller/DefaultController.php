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

    public function bindIssueAction(Application $app, Request $request)
    {
        var_dump($request->query->all());
        $issue = $this->getIssueService()->bindUserToIssue($userId,$issueId);
        return $app->json('https://ss2.baidu.com/6ONYsjip0QIZ8tyhnq/it/u=1150491410,2439285582&fm=58');
    }

    // public function showUsers(Application $app, Request $request)
    // {
    //     $users = $this->getUserService()->findAllUsers();
    //     return $app['twig']->r
    // }

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