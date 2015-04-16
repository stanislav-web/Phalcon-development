<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('DELETE Logout: /api/v1/sign');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendPOST('api/v1/sign', [
    'login' => mt_rand().'@'.mt_rand().'.com',
    'name'  => 'CodeceptionTester',
    'password' => mt_rand()
]);

$auth = $I->grabDataFromJsonResponse();
$user_id = $auth['data'][0]['user_id'];

$I->sendDELETE('api/v1/sign/'.$user_id);

$I->seeResponseCodeIs(204);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'DELETE');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();