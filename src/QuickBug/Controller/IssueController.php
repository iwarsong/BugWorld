<?php

namespace QuickBug\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\ControllerProviderInterface;
use QuickBug\Kernel;
use QuickBug\Common\Paginator;

class IssueController
{

    public function createAction(Application $app, Request $request)
    {
        $issue = $request->request->all();

        $issue['projectId'] = 1;

        $issue = $this->getIssueService()->addIssue($issue);

        return $app->json($issue);
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