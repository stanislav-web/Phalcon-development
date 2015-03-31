<?php 
$I = new ApiTester($scenario);

$I->wantTo('GET errors list: /api/v1/errors');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/errors');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');