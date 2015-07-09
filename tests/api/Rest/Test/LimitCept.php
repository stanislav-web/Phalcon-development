<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();
$I = new ApiTester($scenario);

$I->wantTo('GET limit records: /api/v1/logs?limit=5');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'admin@admin.ua', 'password' => 'admin@admin.ua']);

$auth = $I->grabDataFromResponseByJsonPath('$..data');
$I->amBearerAuthenticated($auth[0]['access']['token']);

$I->sendGET('/api/v1/logs?limit=5');

$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContainsJson(['limit' => 5]);
