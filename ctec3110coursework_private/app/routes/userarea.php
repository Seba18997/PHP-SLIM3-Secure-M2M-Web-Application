<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->post('/userarea',
    function(Request $request, Response $response) use ($app)
    {
        $tainted_parameters  = $request->getParsedBody();
        $tainted_username = $tainted_parameters['user_name'];
        $password = $tainted_parameters['password'];
        $cleaned_username = cleanupUsername($app, $tainted_username);

        $db_params = paramsFromDB($app, $cleaned_username);

        $outcome = compare($app, $db_params['password'], $password);
        //var_dump($db_params['password']);
        $sid = session_id();

        if($outcome == true ) {
            $result = doSession($app, $db_params['password'], $cleaned_username, $sid);
        }

        $isloggedin = ifSetUsername($app)['introduction'];
        $username = ifSetUsername($app)['username'];

        if($outcome == false ) {
            return $this->view->render($response,
                'invalid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'login',
                    'page_title' => 'Login Form',
                    'page_heading_1' => 'Invalid credentials',
                ]);
        } else {

            return $this->view->render($response,
                'valid_login.html.twig',
                [
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'page_heading' => APP_NAME,
                    'method' => 'post',
                    'action' => 'displaycircutboardstate',
                    'action2' => 'displaymessages',
                    'page_title' => 'Login Form',
                    'is_logged_in' => $isloggedin,
                    'username' => $username,
                ]);}

    } )->setName('userarea');


/**
 * @param $app
 * @param $tainted_username
 * @return mixed
 */

function cleanupUsername($app, $tainted_username)
{

    $validator = $app->getContainer()->get('Validator');

    $tainted_username = $tainted_username;

    $cleaned_username = $validator->sanitiseString($tainted_username);

    return $cleaned_username;
}


/**
 * @param $app
 * @param $username
 * @return mixed
 */

function paramsFromDB($app, $username)
{
    $database_wrapper = $app->getContainer()->get('DatabaseWrapper');
    $sql_queries = $app->getContainer()->get('SQLQueries');
    $auth_model = $app->getContainer()->get('Authentication');

    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $auth_model->setSqlQueries($sql_queries);
    $auth_model->setDatabaseConnectionSettings($database_connection_settings);
    $auth_model->setDatabaseWrapper($database_wrapper);

    $params = $auth_model->getParamsDb($username);

    return $params;
}

/**
 * @param $app
 * @param $db_pass
 * @param $typed_pass
 * @return int
 */

function compare($app, $db_pass, $typed_pass)
{
    if($db_pass == 'Invalid_credentials') {
        $outcome = false;
    } else {

        $compare = $app->getContainer()->get('bcryptWrapper');
        $passwordCheck = $compare->authenticatePassword($typed_pass, $db_pass);
    }

    if($passwordCheck == true) {
        $outcome = true;
    } else {
        $outcome = false;
    }

        return $outcome;
}

function doSession($app, $password, $username, $sid)
{
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $session_model = $app->getContainer()->get('SessionModel');

    $session_model->setSessionUsername($username);
    $session_model->setSessionPassword($password);
    $session_model->setSessionId($sid);
    $session_model->setSessionWrapperFile($session_wrapper);
    $session_model->storeData();

    $store_var = array($session_wrapper->getSessionVar('username'),
        $session_wrapper->getSessionVar('password'),
        $session_wrapper->getSessionVar('sid'));

    return $store_var;
}

function ifSetUsername($app){
    $session_wrapper = $app->getContainer()->get('SessionWrapper');
    $username = $session_wrapper->getSessionVar('username');
    if (!empty($username)){
        $result['introduction'] = 'User logged in as ';
        $result['username'] = $username;
    }  else {
        $result['introduction'] = 'Log in to see messages/circuit board ';
        $result['username'] = '';
    }
    return $result;
}