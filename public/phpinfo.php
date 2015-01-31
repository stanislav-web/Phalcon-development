<?php
class Name {
    protected $s = 'SSSS';
};



$new = new Name();

print $new["\0*s\0"];

var_dump($new);
?>