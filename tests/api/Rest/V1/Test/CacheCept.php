<?php
$I = new ApiTester($scenario);

$I->wantTo('GET cached page: /api/v1/pages');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/pages');
$I->sendGET('api/v1/pages');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('ETag');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');