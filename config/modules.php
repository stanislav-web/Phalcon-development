<?php
/**
 * BE CAREFUL!
 * This section contains the settings of loaded modules
 */

$app->registerModules([
    'Rest' => [
        'className' => 'Application\Modules\Rest',
        'path' => APP_PATH . '/Modules/Rest/Rest.php',
    ],
])->setDefaultModule('Rest');
