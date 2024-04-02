<!DOCTYPE html>

<?php
require_once("path.php");
require_once(ROOT . '/app/database/db.php');
require_once(ROOT . '/app/controllers/leads.php');
?>


<body>
<!-- Including navigation bar with two buttons -->
<?php include(ROOT . '/app/includes/navbar.php') ?>
<h1>Форма для відправки даних</h1>
<form action="index.php" method="POST">
    <label for="firstName">Ім'я:</label><br>
    <input type="text" id="firstName" name="firstName" required><br>
    <label for="lastName">Прізвище:</label><br>
    <input type="text" id="lastName" name="lastName" required><br>
    <label for="phone">Телефон:</label><br>
    <input type="tel" id="phone" name="phone" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <input type="submit" value="Відправити" name="addlead">
</form>
</body>
</html>