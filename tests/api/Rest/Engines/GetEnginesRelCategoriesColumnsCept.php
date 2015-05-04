<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET engine -> categories by rel (columns): /api/v1/engines/1/categories?columns=id,host');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/engines/1/categories?columns=id,host');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.engines.id');
$I->seeResponseJsonMatchesJsonPath('$.data.engines.host');
$I->seeResponseJsonMatchesJsonPath('$.data.categories');
