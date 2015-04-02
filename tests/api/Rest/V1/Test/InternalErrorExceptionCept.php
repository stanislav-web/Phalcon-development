<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET 500 Internal Server Error: /api/v1/test');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/test');
$I->seeResponseCodeIs(500);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');