<?php
    require_once('path.php');
    require_once(ROOT . '/app/controllers/leads.php')
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ліди</title>
</head>
<body>
<?php include(ROOT . '/app/includes/navbar.php') ?>
<h1>Ліди</h1>
<form action="results.php" method="POST">
<!--    Doesn't work at all -->
<!--    <label for="date">Оберіть початкову дату:</label><br>-->
<!--    <input type="datetime-local" id="date" name="date_from"><br>-->
    <label for="secondDate">Оберіть кінцеву дату:</label><br>
    <input type="datetime-local" id="secondDate" name="date_to"><br>
    <input type="submit" value="Фільтрувати" name="date_pick" style="margin: 10px 0;">
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