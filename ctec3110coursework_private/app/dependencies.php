<?php

use M2MAPP\MessagesModel;
use M2MAPP\DatabaseWrapper;
use M2MAPP\SQLQueries;
use M2MAPP\SoapWrapper;
use M2MAPP\Helper;

$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(
    $container['settings']['view']['template_path'],
    $container['settings']['view']['twig'],
    [
      'debug' => true // This line should enable debug mode
    ]
  );

  // Instantiate and add Slim specific extension
  $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

  return $view;
};

$container['Helper'] = function ($container) {
  $helper = new Helper();
  return $helper;
};

$container['DisplayMessages'] = function ($container) {
    $model = new MessagesModel();
    return $model;
};

$container['SoapWrapper'] = function ($container) {
    $wrapper = new SoapWrapper();
    return $wrapper;
};
$container['DatabaseWrapper'] = function ($container) {
    $wrapper = new DatabaseWrapper();
    return $wrapper;
};
$container['SQLQueries'] = function ($container) {
    $wrapper = new SQLQueries();
    return $wrapper;
};