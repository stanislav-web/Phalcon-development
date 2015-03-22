<?php
$I = new ApiTester($scenario);

$I->wantTo('Authorization: GET /api/v1/users/auth');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/users/auth', ['login' => 'stanisov@gmail.com', 'password' => 'stanisov@gmail.com']);

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');