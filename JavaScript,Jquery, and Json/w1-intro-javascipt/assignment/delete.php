<?php
require_once "pdo.php";
session_start();

if (isset($_POST['delete']) && isset($_POST['autos_id'])) {
  $sql = "DELETE FROM autos WHERE autos_id = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['autos_id']));
  $_SESSION['success'] = 'Record deleted';
  header('Location: index.php');
  return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['autos_id'])) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT make, autos_id FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = 'Bad value for user_id';
  header('Location: index.php');
  return;
}

?>
<html>

<head>
  <title>95e61034 Tung Le - Broken Rock Paper Scissors</title>
  <?php require_once "bootstrap.php"; ?>
</head>

<body>
  <div class="container">
    <p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>

    <form method="post">
      <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
      <input type="submit" value="Delete" name="delete">
      <a href="index.php">Cancel</a>
    </form>
  </div>
</body>

</html>