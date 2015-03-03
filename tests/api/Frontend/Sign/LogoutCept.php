<?php 
$I = new ApiTester($scenario);
$I->wantTo('Logout: DELETE /sign/logout');
$I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
$I->sendDELETE('/sign/logout');
$I->seeResponseIsJson();
$I->seeResponseContains('{"success":true}');
