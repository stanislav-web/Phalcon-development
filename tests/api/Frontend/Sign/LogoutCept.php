<?php 
$I = new ApiTester($scenario);
$I->wantTo('Logout: DELETE /sign/logout');
$I->sendDELETE('/sign/logout');
$I->seeResponseCodeIs(200);