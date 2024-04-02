<?php
    require_once('path.php');
    require_once(ROOT . '/app/controllers/leads.php')
?>
<!DOCTYPE html>
<html>
<head>
    <title>Лиды</title>
</head>
<body>
<?php include(ROOT . '/app/includes/navbar.php') ?>
<h1>Лиды</h1>
<form action="results.php" method="get">
    <label for="date">Выберите дату:</label><br>
    <input type="date" id="date" name="date">
    <input type="submit" value="Фильтровать">
</form>
<table>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Статус</th>
        <th>FTD</th>
    </tr>
    <?php foreach($leads as $key=>$lead): ?>
    <tr>
        <th><?=$lead['id']?></th>
        <th><?=$lead['email']?></th>
        <th><?=$lead['status']?></th>
        <th><?=$lead['ftd']?></th>
    </tr>
    <?php endforeach;?>
</table>
</body>
</html>