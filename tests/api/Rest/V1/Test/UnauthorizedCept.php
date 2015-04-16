<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET 401 Unauthorized: /api/v1/users');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/users');
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');
