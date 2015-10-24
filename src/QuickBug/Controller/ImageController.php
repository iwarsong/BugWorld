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

        $filename = time() . '-' . rand(10000, 99999) . '.jpg';
        $directory = realpath(__DIR__ . '/../../../web/upload');

        $file->move($directory, $filename);

        return $app->json(['image' => '/upload/' . $filename]);
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