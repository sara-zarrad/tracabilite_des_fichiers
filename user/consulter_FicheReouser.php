<?php

include '../components/connect_bd.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reference'])) {
    $search_reference = $_GET['reference'];

    // Perform a search query using the provided reference
    $search_query = $conn->prepare(
        'SELECT * FROM fiche_reponse WHERE reference LIKE :search_reference'
    );
    $search_query->execute([
        'search_reference' => '%' . $search_reference . '%',
    ]);

    // Fetch and display the results
    $results = $search_query->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no reference is provided, fetch all records
    $sqlQuery = 'SELECT * FROM fiche_reponse';
    $requete = $conn->prepare($sqlQuery);
    $requete->execute();
    $results = $requete->fetchAll(PDO::FETCH_ASSOC);
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
    <title>les fiches reponses </title>
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
                    <li>
                    <form class="search-form" action="../components/resultat_rechFRuser.php">
                        <input type="text" placeholder="rechercher par ref" name="reference" />
                    </form>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../user/acceuil_user.php">Page d'acceuil</a>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../components/user_logout.php">Deconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php
        $sqlQuery =
            'SELECT reference,nom,description,fichier FROM fiche_reponse';
        $requete = $conn->prepare($sqlQuery);
        $requete->execute();
        $res = $requete->fetchAll();
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">reference fiche contrôle </th>';
        echo '<th scope="col">Nom </th>';
        echo '<th scope="col">Description</th>';
        echo '<th scope="col">Fichier pdf</th>';
        echo '<th scope="col"></th>';
        echo '<th scope="col"></th>';
        echo '</tr></thead>';
        foreach ($res as $FR) {
            echo '<tbody><tr><td>' .
                $FR['reference'] .
                '</td><td>' .
                $FR['nom'] .
                '</td><td>' .
                $FR['description'] .
                '</td><td>' .
                $FR['fichier'] .
                '</td><td>
                </td><td>
        <form action="../components/viewerFR.php" method="GET">
    <input type="hidden" name="fichier" value="' .
                $FR['fichier'] .
                '">
    <button type="submit" name="afficher_fichier" class="btn">Afficher</button>
</form></td>
                </tr></tbody>';
        }
        echo '</table><br><br>';
        ?>
    </div>
    <script>
    // JavaScript function to set the article_id for deletion
    function setArticleRef(articleRef) {
        document.getElementById('article_ref').value = articleRef;
    }

    // JavaScript function to open the print dialog
    function imprimerArticle() {
        window.print();
    }

    // JavaScript function to close the modal
    function closeModal() {
        var modal = document.getElementById('modal');
        modal.style.display = 'none';
    }

    // Attach event listeners to close the modal
    var closeButtons = document.querySelectorAll('[data-modal-close]');
    closeButtons.forEach(function (button) {
        button.addEventListener('click', closeModal);
    });

    // Attach event listener to open the modal
    var deleteButtons = document.querySelectorAll('[data-modal-target="#modal"]');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var modalId = this.getAttribute('data-modal-target');
            var modal = document.querySelector(modalId);
            modal.style.display = 'block';
        });
    });
</script>
</body>
</html>