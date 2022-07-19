<?php

main();

function main()
{
    $orderList = new \stdClass();
    $orderList->id = "OrderService/OrderList";
    $orderList->version = 1;
    $orderList->orders = array();

    if (file_exists("data")) {
        chdir("data");
    } else {
        respondWithError($orderList, "Directory 'data' does not exist.");
    }

    if (file_exists($_GET["shop"])) {
        chdir($_GET["shop"]);
    } else {
        respondWithError($orderList, "Shop '" . $_GET["shop"] ."' does not exist.");
    }

    if (file_exists("orders")) {
        chdir("orders");
    } else {
        respondWithError($orderList, "Directory 'orders' does not exist.");
    }

    $date = date("Y-m-d");

    if (isset($_GET["date"])) {
        $date = $_GET["date"];
    }

    if (file_exists($date)) {
        chdir($date);
    } else {
        respondWithError($orderList, "No orders placed on: " . $date);
    }

    $scannedDirectory = array_diff(scandir('.'), array('..', '.', '.DS_Store'));

    if (empty($scannedDirectory)) {
        respondWithError($orderList, "No orders placed on: " . $date);
    }

    foreach ($scannedDirectory as $key => $value) {
        array_push($orderList->orders, 'data/' . $_GET["shop"] . '/orders/' . $date . '/' . $value);
    }

    echo json_encode($orderList);
}

function respondWithError($orderList, $error)
{
    $orderList->error = $error;
    echo json_encode($orderList);
    exit(0);
}
