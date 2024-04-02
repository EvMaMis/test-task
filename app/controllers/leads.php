<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addlead'])) {
    $api = curl_init();

    $data = [
        'firstName' => $_POST['fisrtName'],
        'lastName' => $_POST['lastName'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'box_id' => 28,
        'offer_id' => 5,
        'countyCode' => 'GB',
        'language' => 'en',
        'password' => 'qwerty12',
        'ip' => $_SERVER['REMOTE_ADDR'],
        'landingUrl' => $_SERVER['HTTP_REFERER'],
    ];
    dd($data);
    curl_setopt($api, CURLOPT_URL, API_URL . 'addlead');
    curl_setopt($api, CURLOPT_POST, 1);
    curl_setopt($api, CURLOPT_HTTPHEADER, [
        'token' => TOKEN,
        'Content-Type' => 'multipart/form-data',
    ]);
    curl_setopt($api, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($api);
    print_r('results');
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
    curl_setopt($api, CURLOPT_HTTPHEADER, [
        'token' => TOKEN,
    ]);
    $leads = curl_exec($api);
    curl_close($api);

    if($leads === false) {
        echo "Ошибка получения данных";
    } else {
        $statuses = json_decode($leads, true);
        foreach ($statuses as $status) {
            echo "<tr>";
            echo "<td>" . $status['id'] . "</td>";
            echo "<td>" . $status['email'] . "</td>";
            echo "<td>" . $status['status'] . "</td>";
            echo "<td>" . $status['ftd'] . "</td>";
            echo "</tr>";
        }

    }
    dd($leads);
}

function dd($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}