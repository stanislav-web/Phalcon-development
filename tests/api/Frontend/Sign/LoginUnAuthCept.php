<?php
$I = new ApiTester($scenario);
$I->wantTo('Unauthorized Login: POST sign/login');

$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded;charset=UTF-8');
$I->haveHttpHeader('Accept-Language', 'en-GB,ru;q=0.8,en-US;q=0.6,en;q=0.4,uk;q=0.2');
$I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');

$I->sendPOST('sign/login', [
    'login' => 'stanisov@gmail.com',
    'password' => 'stanisov@gmail.com'
]);
$I->seeResponseCodeIs(401);
$I->seeResponseIsJson();

