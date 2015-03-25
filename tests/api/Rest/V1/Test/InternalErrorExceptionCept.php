<?php 
$I = new ApiTester($scenario);

$I->wantTo('Get 500 Internal Server Error: GET /api/v1/test/show500');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/test/show500');
$I->seeResponseCodeIs(500);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');