<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET categories list: /api/v1/categories');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/categories');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data[*]');
