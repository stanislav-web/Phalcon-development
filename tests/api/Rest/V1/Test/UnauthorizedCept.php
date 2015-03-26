<?php
$I = new ApiTester($scenario);

$I->wantTo('Get 401 Unauthorized: GET /api/v1/users');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/users');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');