<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('POST 400 Required Fields: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/sign');
$I->seeResponseCodeIs(400);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');