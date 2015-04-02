<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('POST Registration: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPOST('api/v1/sign', [
    'login' => mt_rand().'@'.mt_rand().'.com',
    'name'  => 'CodeceptionTester',
    'password' => mt_rand()
]);

$I->seeResponseCodeIs(201);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'POST');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');