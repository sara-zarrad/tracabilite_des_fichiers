<?php

$db_name = 'mysql:host=localhost;dbname=traçabilite_fichiers';
$user_name = 'root';
$user_password = '';

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}

$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from form
    $nom_admin = $_POST['nom_admin'];
    $motdepasse = $_POST['motdepasse'];
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare(
            'SELECT * FROM admin WHERE nom_admin=:nom_admin AND motdepasse=:motdepasse'
        );
        // Bind parameters
        $stmt->bindParam(':nom_admin', $nom_admin);
        $stmt->bindParam(':motdepasse', $motdepasse);
        // Execute statement
        $stmt->execute();

        // If result is found, log in user
        if ($stmt->rowCount() == 1) {
            // Start session and set logged in user
            session_start();
            $_SESSION['nom_admin'] = $nom_admin;

            // Redirect to dashboard or any other page
            header('Location: ../admin/dashboard_admin.php');
            exit();
        } else {
            // Display error message
            $error = 'Invalid nom_admin or password.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="../img/logo paf.png" rel="icon" />
    <link href="../css/connection.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <title>connexion administrateur</title>
    </head>

<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <img src="../img/logo paf.png" id="icon" alt="User Icon" />
            </div>
            <h2>Connexion d'administrateur</h2>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?php echo $_GET[
                    'error'
                ]; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <input type="text" id="nom_admin" class="form-control" name="nom_admin" placeholder="Nom d'utilisateur" required>
                <input type="password" id="motdepasse" class="form-control" name="motdepasse" placeholder="Mot de passe" required>
                <div id="formFooter">
                    <button type="submit" name="submit" value="connexion">Connexion</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>