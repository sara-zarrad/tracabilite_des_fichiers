<?php

include '../components/connect_bd.php';

session_start();

if (isset($_SESSION['id_utilisateur'])) {
    $id_utilisateur = $_SESSION['id_utilisateur'];
} else {
    $id_utilisateur = '';
}

if (isset($_POST['submit'])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $nom_utilisateur = filter_var($nom_utilisateur, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $motdepasse = sha1($_POST['motdepasse']);
    $motdepasse = filter_var($motdepasse, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare(
        'SELECT * FROM `utilisateur` WHERE nom_utilisateur = ?'
    );
    $select_user->execute([$nom_utilisateur]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $message[] = 'nom_utilisateur deja existe!';
    } else {
        $insert_user = $conn->prepare(
            'INSERT INTO `utilisateur`(nom_utilisateur, email, motdepasse) VALUES(?,?,?)'
        );
        $insert_user->execute([$nom_utilisateur, $email, $motdepasse]);
        $message[] = 'registered successfully, login now please!';
        //email
        $subject = 'Bienvenue sur votre site web';
        $body =
            "Cher $nom_utilisateur,\n\n" .
            "Merci de vous être inscrit sur votre site web!\n\n" .
            "Vos identifiants de connexion sont les suivants:\n" .
            "Nom d'utilisateur: $nom_utilisateur\n" .
            "Mot de passe: $motdepasse \n\n" .
            "Veuillez vous connecter et changer votre mot de passe immédiatement.\n\n" .
            "Cordialement,\nL'équipe de votre site web";

        // Replace 'your_email@example.com' with your actual email address
        $headers = 'From: sarra.zarrad23@gmail.com';

        // Use the mail() function to send the email
        mail($email, $subject, $body, $headers);

        // Redirect the user to a login page or another relevant page
        header('Location:../admin/dashboard_admin.php');
        exit();
    }
}
?>
<html>
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
    <link href="../css/creationutilisateur.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <title>creation compte utilisateur</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="../img/logo paf.png" height="60" alt="Logo">
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto" id="list">
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../admin/dashboard_admin.php">Page d'acceuil</a>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../components/admin_logout.php">Deconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>
        <h4>
            Creation de compte d'utilisateur. 
        </h4>
        <div class="wrapper fadeInDown">
            <form action="" method="POST"  enctype="multipart/form-data" >
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" id="nom_utilisateur">Nom d'utilisateur/CIN</label>
                    <input type="text" class="form-control" placeholder="Nom d'utilisateur = CIN" name="nom_utilisateur" />
                </div>
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" for="email">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" />
                </div>
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" for="motdepasse">Mot de passe :</label>
                    <input type="password" class="form-control" id="motdepasse" name="motdepasse" placeholder="Mot de passe" />
                </div>
                
                <div id="formFooter">
                    <button type="submit" name="submit">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>