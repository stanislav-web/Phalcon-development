<?php 
$I = new ApiTester($scenario);

$I->wantTo('GET 404 NotFound: /api/v1/undefined/page');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/test/page');
$I->seeResponseCodeIs(404);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');