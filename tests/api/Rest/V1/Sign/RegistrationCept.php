<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);
$login = mt_rand().'@'.mt_rand().'.com';
$password = mt_rand();
$name = 'CodeceptionTester';

$I->wantTo('POST Registration: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPOST('api/v1/sign', [
    'login' => $login,
    'name'  => $name,
    'password' => $password
]);

$I->seeResponseCodeIs(201);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'POST');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();

$I->sendGET('api/v1/sign', ['login' => $login, 'password' => $password]);
$auth = $I->grabDataFromJsonResponse();
$user_id = $auth['data']['user_id'];
$I->sendDELETE('api/v1/sign/'.$user_id);