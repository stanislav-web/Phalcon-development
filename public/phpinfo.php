<?php
$a = new \NumberFormatter("it-IT", \NumberFormatter::CURRENCY);
echo $a->format(12345.12345) . "<br>"; // outputs €12.345,12
?>
phpinfo();