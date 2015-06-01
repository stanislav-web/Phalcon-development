<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);
$email = (int)mt_rand().'@'.(int)mt_rand().'.com';

$I->wantTo('POST Subscribe: /api/v1/subscribe');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPOST('api/v1/subscribe', [
    'email' => $email,
]);

$I->seeResponseCodeIs(201);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'POST');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.email');
