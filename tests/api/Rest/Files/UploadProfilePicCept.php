<?php
    $scenario = (null !== $scenario) ? $scenario : new \StdClass();

    $login = (int)mt_rand().'@'.(int)mt_rand().'.com';
    $password = (int)mt_rand();
    $name = 'CodeceptionTester';
    $filename = 'profile.jpg';
    $I = new ApiTester($scenario);

    $I->wantTo('POST upload profile picture: /api/v1/files');
    $I->setHeader('Accept', '*/*');
    $I->setHeader('Accept-Language', 'en-GB');

    $I->sendPOST('api/v1/sign', [
        'login' => $login,
        'name'  => $name,
        'password' => $password
    ]);

    $I->sendGET('api/v1/sign', ['login' => $login, 'password' => $password]);
    $auth = $I->grabDataFromResponseByJsonPath('$..data');

    $auth = $auth[0]['access'];
    $I->amBearerAuthenticated($auth['token']);

    $I->setHeader('Accept', '*/*');
    $I->setHeader('Accept-Language', 'en-GB');

    $I->sendPOST('api/v1/files/', [
        'mapper'    =>  'UserMapper',
        'id'        =>  $auth['user_id']
    ], [codecept_data_dir($filename)]
    );

    $I->seeResponseCodeIs(201);
    $I->seeHttpHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE');
    $I->seeHttpHeader('Access-Control-Allow-Origin', '*');
    $I->seeResponseIsJson();
    $I->seeResponseJsonMatchesJsonPath('$.meta');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.path');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.directory');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.filename');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.size');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.extension');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.small.name');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.small.path');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.small.directory');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.small.extension');
    $I->seeResponseJsonMatchesJsonPath('$.data.files.small.size');
