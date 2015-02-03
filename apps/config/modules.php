<?php

// Register modules
$application->registerModules([
    'Frontend' => [
        'className' => 'Modules\Frontend',
        'path' => APP_PATH . '/Modules/Frontend/Module.php',
    ],
    'Backend' => [
        'className' => 'Modules\Backend',
        'path' => APP_PATH . '/Modules/Backend/Module.php',
    ],
])->setDefaultModule('Frontend');
