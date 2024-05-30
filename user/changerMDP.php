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

session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nouveauMotDePasse = $_POST['motdepasse'];
    $confirmNouveauMotDePasse = $_POST['nvmotdepasse'];
    $ancienMotDePasse = $_POST['ancienmotdepasse'];

    // Validate form data (you may want to add more validation)
    if ($nouveauMotDePasse !== $confirmNouveauMotDePasse) {
        $error = 'Les nouveaux mots de passe ne correspondent pas.';
    } else {
        // Perform password change logic
        // You need to retrieve the current user's password from your database and compare it with $ancienMotDePasse
        // If the old password matches, update the password with $nouveauMotDePasse in the database
        // Make sure to hash the new password before storing it in the database for security reasons
        // This code assumes you have a valid database connection stored in $conn

        try {
            // Assuming you have a 'utilisateur' table with a column 'motdepasse' for storing passwords
            $stmt = $conn->prepare(
                'UPDATE utilisateur SET motdepasse = :nouveauMotDePasse WHERE motdepasse = :ancienMotDePasse'
            );
            $stmt->bindParam(':nouveauMotDePasse', $nouveauMotDePasse);
            $stmt->bindParam(':ancienMotDePasse', $ancienMotDePasse);

            $stmt->execute();

            // Check if the password was updated successfully
            if ($stmt->rowCount() > 0) {
                $success = 'Mot de passe changé avec succès.';
                header('Location: ../user/connection_utilisateur.php');
                exit();
            } else {
                $error = 'Mot de passe ancien incorrect.';
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

/*if (isset($_SESSION['id_utilisateur'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = $_POST['motdepasse'];
        $confirm_password = $_POST['nvmotdepasse'];
        $old_password = $_POST['ancienmotdepasse'];

        // Validation côté serveur
        if (
            empty($new_password) ||
            empty($confirm_password) ||
            empty($old_password)
        ) {
            $password_change_error_message =
                'Veuillez remplir tous les champs.';
        } else {
            // Retrieve the user's current password from the database
            $stmt = $conn->prepare(
                'SELECT motdepasse FROM utilisateur WHERE id_utilisateur = ?'
            );
            $stmt->execute([$_SESSION['id_utilisateur']]);
            $row = $stmt->fetch();
            $hashed_password = $row['motdepasse'];

            // Vérifie si l'ancien mot de passe correspond à celui dans la base de données
            if (password_verify($old_password, $hashed_password)) {
                // Vérifie si le nouveau mot de passe correspond à la confirmation
                if ($new_password === $confirm_password) {
                    // Hash le nouveau mot de passe
                    $hashed_new_password = password_hash(
                        $new_password,
                        PASSWORD_DEFAULT
                    );

                    // Met à jour le mot de passe de l'utilisateur dans la base de données
                    $update_password = $conn->prepare(
                        'UPDATE utilisateur SET motdepasse = ? WHERE id_utilisateur = ?'
                    );
                    $update_password->execute([
                        $hashed_new_password,
                        $_SESSION['id_utilisateur'],
                    ]);

                    $_SESSION['success_message'] =
                        'Le mot de passe a été changé avec succès!';
                    header('Location: ../user/connection_utilisateur.php');
                    exit();
                } else {
                    $password_change_error_message =
                        'Les nouveaux mots de passe ne correspondent pas.';
                }
            } else {
                $password_change_error_message =
                    'Ancien mot de passe invalide.';
            }
        }
    }
}*/
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
    <script src="rollbutton.js"></script>
    <link href="../img/logo paf.png" rel="icon" />
    <link href="../css/connection.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <title>Changer le mot de passe</title>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
            <div class="fadeIn first">
                <img src="../img/logo paf.png" id="icon" alt="User Icon" />
            </div>
            <h2>Changer le mot de passe</h2>
            <form action="" method="POST">
                <input type="password" id="motdepasse" class="form-control" name="motdepasse" placeholder="Nouveau mot de passe" required>
                <input type="password" id="nvmotdepasse" class="form-control" name="nvmotdepasse" placeholder="Confirmer le nouveau mot de passe" required>
                <input type="password" id="ancienmotdepasse" class="form-control" name="ancienmotdepasse" placeholder="Ancien mot de passe" required>
                <input type="submit" class="fadeIn fourth" value="Changer le mot de passe">
            </form>
            <?php if (isset($password_change_error_message)): ?>
                <div class="alert alert-danger"><?php echo $password_change_error_message; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>