<?php

use M2MAPP\MessagesModel;
use M2MAPP\DatabaseWrapper;
use M2MAPP\SQLQueries;
use M2MAPP\SoapWrapper;
use M2MAPP\Helper;
use M2MAPP\Validator;
use M2MAPP\DownloadMessagesToDatabase;
use M2MAPP\Decoder;

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
    $swrapper = new SoapWrapper();
    return $swrapper;
};

$container['DatabaseWrapper'] = function ($container) {
    $dwrapper = new DatabaseWrapper();
    return $dwrapper;
};

$container['SQLQueries'] = function ($container) {
    $queries = new SQLQueries();
    return $queries;
};

$container['Validator'] = function ($container) {
    $validator = new Validator();
    return $validator;
};

$container['DownloadMessagesToDatabase'] = function ($container) {
    $downloader = new DownloadMessagesToDatabase();
    return $downloader;
};

$container['Decoder'] = function ($container) {
    $decoder = new Decoder();
    return $decoder;
};
