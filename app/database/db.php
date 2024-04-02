<?php

session_start();
require("connect.php");

function tt($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}


// Проверка запроса к базе данных
function dbCheckError($query)
{
    $errInfo = $query->errorInfo();

    if ($errInfo[0] !== PDO::ERR_NONE) {
        echo $errInfo[2];
        exit();
    }
    return true;
}

// Запрос на получение определенного количества данных с одной таблицы
function selectAny($table, $params = [], $number = 0)
{
    global $pdo;
    $sql = "SELECT * FROM $table";
    if (!empty($params)) {
        $i = 0;
        foreach ($params as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE `$key` = '$value'";
            } else {
                $sql = $sql . " AND `$key` = '$value'";
            }
            $i++;
        }
    }
    if ($number != 0)
        $sql = $sql . " LIMIT $number";


    $query = $pdo->prepare($sql);
    $query->execute();

    dbCheckError($query);
    if ($number === 1) {
        return $query->fetch();
    }
    return $query->fetchAll();
}

// Вставка в таблицу
function insert($table, $params)
{
    global $pdo;
    $keys = "";
    $values = "";
    foreach ($params as $key => $value) {
        $keys = $keys . " `$key`,";
        $values = $values . " '$value',";
    }
    // Удаляет лишнюю запятую в конце
    $keys = substr_replace($keys, "", -1);
    $values = substr_replace($values, "", -1);

    $sql = "INSERT INTO `$table` ($keys) VALUES($values)";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $pdo->lastInsertId();
}

// Функция для обновления по id
function update($table, $id, $params)
{
    global $pdo;
    $sql = "UPDATE `$table` SET ";
    foreach ($params as $key => $value) {
        $sql = $sql . " `$key` = '$value',";
    }
    // Удаляет лишнюю запятую в конце
    $sql = substr_replace($sql, "", -1);
    $sql = $sql . " WHERE `id` = $id";
    print($sql);
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
}
