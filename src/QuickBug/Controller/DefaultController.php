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
        return $app['twig']->render('default/index.html.twig', array(
        ));
    }

    protected function getAddressService()
    {
        return $this->kernel()->service('AddressService');
    }

    protected function kernel()
    {
        return Kernel::instance();
    }
}