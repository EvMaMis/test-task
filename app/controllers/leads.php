<?php

$errorMessages = [];

// Post method for form
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
        // Check any errors while executing
        if (curl_errno($api)) {
            $errorMessages[] = "Помилка CURL: " . curl_error($api);
        } else {
            $decoded_output = json_decode($output);
            if (!$decoded_output['status']) {
                $errorMessages[] = $decoded_output['error'];
            }
        }
        curl_close($api);
    }
}

// Get all leads
if ($_SERVER['REQUEST_METHOD'] === 'GET' && str_contains($_SERVER['REQUEST_URI'], 'results')) {
    $api = curl_init();

    curl_setopt($api, CURLOPT_URL, API_URL . 'getstatuses');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HTTPHEADER, array("token:" . TOKEN));

    $leads = curl_exec($api);

    if ($leads === false) {
        $errorMessages[] = "Помилка отримання даних";
        dd(curl_error($api));
    } else {
        // gets decoded data
        $data = json_decode($leads, true);
        $leads = $data['data'];
    }
    curl_close($api);

}

// Get leads with date pick (works only with date to, date from doesn't change)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date_pick'])) {
    $api = curl_init();
    $data = [];
    if (isset($_POST['date_to'])) {
        $data = ['date_to' => $_POST['date_to']];
    }
    curl_setopt($api, CURLOPT_URL, API_URL . 'getstatuses');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HTTPHEADER, array("token:" . TOKEN, 'Content-Type: application/json'));
    curl_setopt($api, CURLOPT_POSTFIELDS, json_encode($data));

    $leads = curl_exec($api);

    if ($leads === false) {
        $errorMessages[] = "Помилка отримання даних";
        dd(curl_error($api));
    } else {
        $data = json_decode($leads, true);
        $leads = $data['data'];
    }
    curl_close($api);
}

// Debug function
function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

// Method for checking inputs, not necessary because validation on api works fine
function checkInput($data)
{
    $errorMessages = [];
    // Checks input for first name, last name, phone and email
    return $errorMessages;
}