<?php
$I = new ApiTester($scenario);

$I->wantTo('PUT Restore by Email: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPUT('api/v1/sign', [
    'login' => 'userundefined@gmail.com'
]);

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'PUT');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();