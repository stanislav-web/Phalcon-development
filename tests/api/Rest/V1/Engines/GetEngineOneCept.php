<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET engine by id: /api/v1/engines/1');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/engines/1');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.meta');
$I->seeResponseJsonMatchesJsonPath('$.data.engines');
$I->seeResponseJsonMatchesJsonPath('$.data.currency');
