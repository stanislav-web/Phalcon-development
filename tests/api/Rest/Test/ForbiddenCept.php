<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$login = mt_rand().'@'.mt_rand().'.com';
$password = mt_rand();
$name = 'CodeceptionTester';

$I = new ApiTester($scenario);

$I->wantTo('GET 403 Forbidden: /api/v1/users');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPOST('api/v1/sign', [
    'login' => $login,
    'name'  => $name,
    'password' => $password
]);

$I->sendGET('api/v1/sign', ['login' => $login, 'password' => $password]);
$auth = $I->grabDataFromResponseByJsonPath('$..data');
$I->amBearerAuthenticated($auth[0]['access']['token']);

$I->sendGET('/api/v1/users');

$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');

$I->sendDELETE('api/v1/sign/'.$auth[0]['access']['user_id']);
