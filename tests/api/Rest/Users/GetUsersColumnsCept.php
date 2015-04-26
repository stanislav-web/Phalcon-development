<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET users list columns: /api/v1/users?columns=id,login,name');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'admin@admin.ua', 'password' => 'admin@admin.ua']);
$auth = $I->grabDataFromJsonResponse();
$I->amBearerAuthenticated($auth['data']['token']);

$I->sendGET('/api/v1/users?columns=id,login,name');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET,POST,PUT');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data[*]id');
$I->seeResponseJsonMatchesJsonPath('$.data[*]login');
$I->seeResponseJsonMatchesJsonPath('$.data[*]name');
