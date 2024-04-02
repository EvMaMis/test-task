<?php

$errorMessages = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addlead'])) {
    $errorMessages = checkInput($_POST);
    if (count($errorMessages) === 0) {
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
        if (curl_errno($api)) {
            $errorMessages[] = "Помилка CURL: " . curl_error($api);
        } else {
            $decoded_output = json_decode($output);
            if(!$decoded_output['status']) {
                $errorMessages[] = $decoded_output['error'];
            }
        }
        curl_close($api);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $api = curl_init();
    $url = API_URL . 'getstatuses';
    curl_setopt($api, CURLOPT_URL, $url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HTTPHEADER, array("token:" . TOKEN));
    if(isset($_GET['date_from']) && isset($_GET['date_to'])) {
        $queryParams = http_build_query([
            'date_from' => $_GET['date_from'],
            'date_to' => $_GET['date_to'],
        ]);
        curl_setopt($api, CURLOPT_POSTFIELDS, $queryParams);
    }
    $leads = curl_exec($api);
    curl_close($api);

    if ($leads === false) {
        $errorMessages[] = "Помилка отримання даних";
    } else {
        $data = json_decode($leads, true);
        $leads = $data['data'];
    }
}

function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function checkInput($data)
{
    $errorMessages = [];
    // Checks input for first name, last name, phone and email
    return $errorMessages;
}