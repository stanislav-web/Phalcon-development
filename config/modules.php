<?php
/**
 * BE CAREFUL!
 * This section contains the settings of loaded modules
 */

$application->registerModules([
    'Frontend' => [
        'className' => 'Application\Modules\Frontend',
        'path' => APP_PATH . '/Modules/Frontend/Frontend.php',
    ],
    'Backend' => [
        'className' => 'Application\Modules\Backend',
        'path' => APP_PATH . '/Modules/Backend/Backend.php',
    ],
])->setDefaultModule('Frontend');
