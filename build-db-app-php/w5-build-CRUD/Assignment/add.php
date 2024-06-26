<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['name'])) {
    die("ACCESS DENIED");
}

if(isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

if (
    isset($_POST['fn']) && isset($_POST['ln'])
    && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])
) {
    // Data validation
    if (strlen($_POST['fn']) < 1 || strlen($_POST['ln']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = 'Email address must contain @';
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO Profile (make, model, year, mileage)
              VALUES (:make, :model, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']
    ));
    $_SESSION['success'] = 'Record added';
    header('Location: index.php');
    return;
}

// Flash pattern

?>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>95e61034 Tung Le - Broken Rock Paper Scissors</title>
</head>

<body>
    <div class="container">
        <?php
        echo "<h1>";
        echo 'Adding Profile for ';
        echo htmlentities($_SESSION['name']);
        echo "</h1>\n";
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red">' . htmlentities($_SESSION['error']) . "</p>\n";
            unset($_SESSION['error']);
        }
        ?>
        <form method="post">
            <p>First Name:
                <input type="text" name="fn">
            </p>
            <p>Last Name:
                <input type="text" name="ln">
            </p>
            <p>Email:
                <input type="text" name="email">
            </p>
            <p>Headline:
                <input type="text" name="headline">
            </p>
            <p>Summary:
                <input type="text" name="summary">
            </p>
            <input type="submit" value="Add New" />
            <input type="submit" value="Cancel" name="cancel">
        </form>
    </div>
</body>

</html>