<?php

function var_dumps($dump, $break = false){
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';

    if($break ==  true){
        die();
        return false;
    }
}