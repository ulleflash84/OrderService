<?php

main();

function exitWithError()
{
    echo "Error";
    exit(1);
}

function main()
{
    $order = $_GET["order"];

    if (!file_exists($order)) {
        exitWithError();
    }
    
    if (!unlink($order)) {  
        exitWithError(); 
    }  

    echo "OK";
}
