<?php
include '../components/connect_bd.php';

session_start();
if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['delete_utilisateur'])
) {
    $delete_utilisateur = $_POST['delete_utilisateur'];

    $delete_query = $conn->prepare(
        'DELETE FROM utilisateur WHERE id_utilisateur = ?'
    );
    $delete_query->execute([$delete_utilisateur]);
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
    <script src="../js/rollbutton.js"></script>
    <script defer src="../js/rollbutton.js"></script>
    <link href="../img/logo paf.png" rel="icon" />
    <link href="../css/creationutilisateur.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <title>Affichage des comptes utilisateurs</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="../img/logo paf.png" height="60" alt="Logo">
            </a>
            <!-- <button class="navbar-toggler" type="button" id="rollButton" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span> -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto" id="list">
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../admin/dashboard_admin.php">Page d'acceuil</a>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../admin/admin_logout.php">Deconnexion</a>                    </li>
                </ul>
            </div>
        </nav>
        <?php
        $sqlQuery =
            'SELECT id_utilisateur,nom_utilisateur,email FROM utilisateur';
        $requete = $conn->prepare($sqlQuery);
        $requete->execute();
        $res = $requete->fetchAll();
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">id Utilisateur</th>';
        echo '<th scope="col">Nom utilisateur</th>';
        echo '<th scope="col">Email</th>';
        echo '<th scope="col"></th>';
        echo '</tr></thead>';
        foreach ($res as $user) {
            echo '<tbody><tr><td>' .
                $user['id_utilisateur'] .
                '</td><td>' .
                $user['nom_utilisateur'] .
                '</td><td>' .
                $user['email'] .
                '</td><td>
                <form action="" method="POST">
            <input type="hidden" name="id_utilisateur" value="' .
                $user['id_utilisateur'] .
                '">
            <button type="submit" name="delete_utilisateur" class="btn btn-danger">Supprimer</button>
        </form>
        </td><td>
        </tr></tbody>';
        }
        echo '</table><br><br>';
        ?>
    </div>
</body>
</html>