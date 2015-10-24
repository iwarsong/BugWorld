<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app['DefaultController'] = $app->share(function() use ($app) {
    return new QuickBug\Controller\DefaultController();
});

$app['ImageController'] = $app->share(function() use ($app) {
    return new QuickBug\Controller\ImageController();
});

$app->get('/', 'DefaultController:indexAction')->bind('homepage');
$app->get('/issues/{status}', 'DefaultController:issuesAction')->bind('issues_status');
$app->post('/image/upload', 'ImageController:uploadAction')->bind('image_upload');
$app->get('/issue/{id}', 'DefaultController:issueAction')->bind('issue');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
