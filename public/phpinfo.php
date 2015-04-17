<?php

if(!extension_loaded('apc')){

    die("APC extension is not enabled.");
}

function generate_class_map($size){

    apc_clear_cache('user');

    $map = array();

    $class_prefix = '\Acme\Foo\Bar\Baz\Class';

    $file_prefix = '/path/to/classes/acme/foo/bar/baz';

    for($i = 0; $i < $size; $i++){

        $map[$class_prefix.'_'.$i] = $file_prefix.'_'.$i.'.php';

        apc_store($class_prefix.'_'.$i, $map[$class_prefix.'_'.$i]);
    }

    return $map;
}

function test_array(&$map, $class_name){

    if(isset($map[$class_name])){

        $file = $map[$class_name];

        // include the file
    }
}

function test_apc($class_name){

    $success = false;

    $file = apc_fetch($class_name, $success);

    if($success){

        // include the file
    }
}


$current = $start = 100;

$max = 100000;

if(php_sapi_name() != 'cli'){

    header('Content-Type: text/plain');
}

do{

    $map = generate_class_map($current);

    $start_time = microtime(true);

    for($i = 0; $i < $current; $i++){

        test_array($map, '\Acme\Foo\Bar\Baz\Class_'.$i);
    }

    $array_time = microtime(true) - $start_time;

    $start_time = microtime(true);

    for($i = 0; $i < $current; $i++){

        test_apc('\Acme\Foo\Bar\Baz\Class_'.$i);
    }

    $apc_time = microtime(true) - $start_time;


    echo sprintf("Result for %d items\n", $current);

    echo sprintf("%-12s: %01.8f\n", "APC time", $apc_time);

    echo sprintf("%-12s: %01.8f\n", "Array time", $array_time);

    echo sprintf("%-12s: %01.8f [%% %01.2f]\n", "APC - Array", ($apc_time - $array_time), (100* ($apc_time / $array_time)) - 100);

    echo "-------------------------\n";

    $current *= 10;

}while($current <= $max);