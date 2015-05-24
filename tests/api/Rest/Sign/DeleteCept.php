<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);
$login = (int)mt_rand().'@'.(int)mt_rand().'.com';
$password = (int)mt_rand();
$name = 'CodeceptionTester';

$I->wantTo('DELETE Logout: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPOST('api/v1/sign', [
    'login' => $login,
    'name'  => $name,
    'password' => $password
]);
$I->sendGET('api/v1/sign', ['login' => $login, 'password' => $password]);
$auth = $I->grabDataFromJsonResponse();
$user_id = $auth['data']['access']['user_id'];
$I->amBearerAuthenticated($auth['data']['access']['token']);

$I->sendDELETE('api/v1/sign/'.$user_id);

$I->seeResponseCodeIs(204);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'DELETE');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();