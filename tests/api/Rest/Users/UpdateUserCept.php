<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$name = mt_rand().'@'.mt_rand();

$I->wantTo('PUT user update: /api/v1/users/11');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'admin@admin.ua', 'password' => 'admin@admin.ua']);

$auth = $I->grabDataFromJsonResponse();
$token = $auth['data']['access']['token'];

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');
$I->setHeader('Authorization', 'Bearer '.$token);

$I->sendPUT('api/v1/users', ['id' => 11, 'name' => $name]);

$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET,POST,PUT');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.meta');