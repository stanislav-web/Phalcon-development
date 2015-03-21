<?php 
$I = new ApiTester($scenario);

$I->wantTo('Get user\'s list: GET /api/v1/users');
$I->amBearerAuthenticated('JDJhJDA4JGZjTHJQOVRDUTFiaWtjcW5XNDZ2TE9SRGNJOVVsREdzL0FCczlGY1lmaTNoUC9ERGdqaHY2');
$I->sendGET('api/v1/users');

$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Methods', 'GET,POST,PUT');
$I->seeHttpHeader('Access-Control-Allow-Origin', '*');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data');