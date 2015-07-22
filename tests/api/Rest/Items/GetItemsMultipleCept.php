<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET items multiple list: /api/v1/items/1,2,3,4,5');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/items/1,2,3,4,5');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data[*]');
$I->seeResponseContainsJson(['id' => '1']);
$I->seeResponseContainsJson(['id' => '2']);
$I->seeResponseContainsJson(['id' => '3']);
