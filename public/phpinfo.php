<?php

$sum = 0;
$a   = array();
for($i = 0; $i < 5000; $i++)
{
    $start = microtime(true);
    for($j = 0; $j < 5000; $j++)
    {
        $a[$j] = sizeof($a);
    }
    $sum += microtime(true) - $start;
}
echo 'sizeof median time '.round($sum / 1000, 6)."\n";

$sum = 0;
$a   = array();
for($i = 0; $i < 5000; $i++)
{
    $start = microtime(true);
    for($j = 0; $j < 5000; $j++)
    {
        $a[$j] = count($a);
    }
    $sum += microtime(true) - $start;
}
echo 'count median time '.round($sum / 1000, 6)."\n";

?>