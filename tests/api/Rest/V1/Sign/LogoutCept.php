<?php
$scenario = (null !== $scenario) ? $scenario : new \StdClass();

$I = new ApiTester($scenario);

$I->wantTo('GET Logout: /api/v1/sign/10');

$I->setHeader('Accept', '*/*');
$I->setHeader('Accept-Language', 'en-GB');

$I->sendGET('api/v1/sign', ['login' => 'logoutuser@logoutuser.com', 'password' => 'logoutuser@logoutuser.com']);
$auth = $I->grabDataFromJsonResponse();
$user_id = $auth['data'][0]['user_id'];

$I->sendDELETE('/api/v1/sign/'.$user_id);

$I->seeResponseCodeIs(204);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'DELETE');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');