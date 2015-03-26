<?php 
$I = new ApiTester($scenario);

$I->wantTo('Get 405 Method not allowed: DELETE /api/v1/users');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendDELETE('/api/v1/users');
$I->seeResponseCodeIs(405);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');