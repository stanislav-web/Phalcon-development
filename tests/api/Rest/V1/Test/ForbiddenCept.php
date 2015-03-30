<?php
$I = new ApiTester($scenario);

$I->wantTo('GET 403 Forbidden: /api/v1/users');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'user@gmail.com', 'password' => 'user@gmail.com']);
$auth = $I->grabDataFromJsonResponse();

$I->amBearerAuthenticated($auth['data'][0]['token']);

$I->sendGET('/api/v1/users');

$I->seeResponseCodeIs(403);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');