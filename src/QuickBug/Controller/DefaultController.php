<?php

namespace QuickBug\Controller;

use QuickBug\Common\ArrayToolkit;
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
        $users = $this->getUserService()->findAllUsers();

        $orderBy = array('createdTime', 'DESC');
        $issues = $this->getIssueService()->searchIssues($conditions, $orderBy, 0, 100);
        $users = ArrayToolkit::index($users, 'id');
        return $app['twig']->render('default/index.html.twig', array(
            'issueStatus' => 'todo',
            'issues' => $issues,
            'users' => $users
        ));
    }

    public function issueAction(Application $app, Request $request, $id)
    {
        $issue = $this->getIssueService()->getIssue($id);
        $users = $this->getUserService()->findAllUsers();
        $users = ArrayToolkit::index($users, 'id');
        return $app['twig']->render('default/issue-show-modal.html.twig', array(
            'issue' => $issue,
            'users' => $users
        ));
    }

    public function issuesAction(Application $app, Request $request, $status)
    {
        $searchData = $request->query->all();
        $conditions = $this->processerSearchData($searchData);

        $conditions['status'] = $status;

        $orderBy = array('createdTime', 'DESC');
        $issues = $this->getIssueService()->searchIssues($conditions, $orderBy, 0, 100);
        $users = $this->getUserService()->findAllUsers();
        $users = ArrayToolkit::index($users, 'id');
        return $app['twig']->render('default/issue-grid.html.twig', array(
            'issueStatus' => $status,
            'issues' => $issues,
            'sortMode' => !empty($searchData['sortMode'])?$searchData['sortMode']:'time',
            'users' => $users
        ));
    }

    public function bindIssueAction(Application $app, Request $request)
    {
        $data = $request->request->all();

        //$userId = $data['userId'];
        $issueId = $data['issueId'];

        $issue = $this->getIssueService()->getIssue($issueId);

        $fields = $this->getFieldsByDataAndIssueId($data, $issue['id']);

        if(empty($fields)){
            return $app->json(false);
        }

        $issue = $this->getIssueService()->updateIssue($issue['id'], $fields);

        return $app->json($issue);
    }

    private function getFieldsByDataAndIssueId($data, $issueId)
    {
        $fields = array();
        $userId = $data['userId'];
        $issue = $this->getIssueService()->getIssue($issueId);
        switch($issue['status']){
            case 'todo':
                if($userId == $issue['doUserId']){
                    $fields = array(
                        'status' => 'doing',
                        'doingTime' => time()
                    );
                }else{
                    $fields = array(
                        'doUserId' => $userId
                    );
                }
                break;
            case 'doing':
                $fields = array(
                    'status' => 'done',
                    'doneTime' => time()
                );
                break;
            case 'done':
                $fields = array(
                    'status' => 'checking',
                    'checkingTime' => time()
                );
                break;
            case 'checking':
                $fields = array(
                    'checkUserId' => $userId,
                    'status' => 'finished',
                    'finishedTime' => time()
                );
                if(isset($data['issueRollback']) && $data['issueRollback']){
                    $fields['status'] = 'doing';
                }
                break;
            default:
                break;
        }
        return $fields;
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
            unset($conditions['latest']);
        }

        return $conditions;
    }

    protected function getIssueService()
    {
        return $this->kernel()->service('IssueService');
    }

    protected function getUserService()
    {
        return $this->kernel()->service('UserService');
    }

    protected function kernel()
    {
        return Kernel::instance();
    }
}