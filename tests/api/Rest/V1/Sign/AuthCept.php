<?php
$I = new ApiTester($scenario);

$I->wantTo('GET Authorization: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'stanisov@gmail.com', 'password' => 'stanisov@gmail.com']);

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');