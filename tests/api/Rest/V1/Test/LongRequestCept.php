<?php 
$I = new ApiTester($scenario);

$I->wantTo('GET 414 Long Request: /api/v1/pages?columns=.....');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('/api/v1/pages?columns=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
$I->seeResponseCodeIs(414);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.error');