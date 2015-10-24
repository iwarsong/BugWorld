<?php

namespace QuickBug\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\ControllerProviderInterface;
use QuickBug\Kernel;
use QuickBug\Common\Paginator;

class ImageController
{

    public function uploadAction(Application $app, Request $request)
    {
        $file = $request->files->get('image');

        $file->move('/tmp', 'bug.jpg');

        var_dump($file);exit();


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