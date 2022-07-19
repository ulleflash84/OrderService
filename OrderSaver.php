<?php

main();

function exitWithError()
{
    echo "Error";
    exit(1);
}

function main()
{
    if (!file_exists("data")) {
        mkdir("data");
    }
    chdir("data");

    if (!file_exists($_GET["shop"])) {
        mkdir($_GET["shop"]);
    }
    chdir($_GET["shop"]);

    if (!file_exists("orders")) {
        mkdir("orders");
    }
    chdir("orders");

    $today = date("Y-m-d");

    if (!file_exists($today)) {
        mkdir($today);
    }
    chdir($today);

    $now = new DateTime();
    $now->setTimezone(new DateTimeZone('Europe/Berlin'));
    $file = fopen($now->format("H-i-s_u") . ".json", "w");

    if (!$file) {
        exitWithError();
    }

    if (!fwrite($file, file_get_contents('php://input'))) {
        exitWithError();
    }

    if (!fclose($file)) {
        exitWithError();
    }

    echo "OK";
}
