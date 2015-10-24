<?php

namespace QuickBug\Service;

use QuickBug\Kernel;

abstract class BaseService
{
    protected function kernel()
    {
        return Kernel::instance();
    }

    protected function createServiceException($message = 'Service Exception', $code = 0)
    {
        return new \Exception($message, $code);
    }
}