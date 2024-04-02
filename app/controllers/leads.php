<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addlead'])) {
    $api = curl_init();

    $data = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'box_id' => 28,
        'offer_id' => 5,
        'countryCode' => 'GB',
        'language' => 'en',
        'password' => 'qwerty12',
        'ip' => $_SERVER['REMOTE_ADDR'],
        'landingUrl' => $_SERVER['HTTP_REFERER'],
    ];
    curl_setopt($api, CURLOPT_URL, API_URL . 'addlead');
    curl_setopt($api, CURLOPT_POST, 1);
    curl_setopt($api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token: ' . TOKEN));
    curl_setopt($api, CURLOPT_POSTFIELDS, json_encode($data));
    $output = curl_exec($api);
    if(curl_errno($api)) {
        echo "Помилка CURL: " . curl_error($api);
    } else {
        $decoded_output = json_decode($output);
        echo $decoded_output;
    }
    curl_close($api);

}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, API_URL . 'getstatuses');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HTTPHEADER, array("token:" . TOKEN));

    $leads = curl_exec($api);
    curl_close($api);

    if($leads === false) {
        echo "Ошибка получения данных";
        dd(curl_error($api));
    } else {
        $statuses = json_decode($leads, true);
        $leads = $statuses['data'];
    }
}

function dd($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}