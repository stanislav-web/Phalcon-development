<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET 406 Not Acceptable: /api/v1/users');

$I->setHeader('Accept', 'application/xml');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/users');
$I->seeResponseCodeIs(406);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');
