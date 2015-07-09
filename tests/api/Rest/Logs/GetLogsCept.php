<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET logs list: /api/v1/logs');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'admin@admin.ua', 'password' => 'admin@admin.ua']);
$auth = $I->grabDataFromResponseByJsonPath('$..data');
$I->amBearerAuthenticated($auth[0]['access']['token']);

$I->sendGET('api/v1/logs?limit=5');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');