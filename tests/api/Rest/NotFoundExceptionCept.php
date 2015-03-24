<?php 
$I = new ApiTester($scenario);

$I->wantTo('Get NotFound: GET /api/v1/undefined/page');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/undefined/page');
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');