<?php

include '../components/connect_bd.php';

session_start();

// Check for deletion request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_article'])) {
    $article_ref = $_POST['article_ref'];

    // Delete from the certificat table
    $delete_query = $conn->prepare(
        'DELETE FROM certificat WHERE reference = ?'
    );
    $delete_query->execute([$article_ref]);

    $message = 'Article deleted successfully!';
    $delete_query2 = $conn->prepare('DELETE FROM articles WHERE reference = ?');
    $delete_query2->execute([$article_ref]);
}

// Your existing PHP code for fetching data
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reference'])) {
    $search_reference = $_GET['reference'];

    // Perform a search query using the provided reference
    $search_query = $conn->prepare(
        'SELECT * FROM certificat WHERE reference LIKE :search_reference'
    );
    $search_query->execute([
        'search_reference' => '%' . $search_reference . '%',
    ]);

    // Fetch and display the results
    $results = $search_query->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no reference is provided, fetch all records
    $sqlQuery = 'SELECT * FROM certificat';
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
    <title>les certificats</title>
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
                    <form class="search-form" action="../components/resultat_rechCertifAdmin.php">
                        <input type="text" placeholder="rechercher par ref" name="reference" />
                    </form>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../admin/dashboard_admin.php">Page d'acceuil</a>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../components/admin_logout.php">Deconnexion</a>                    </li>
                    </li>
                </ul>
            </div>
        </nav>
<?php
$sqlQuery = 'SELECT reference,nom,description,fichier FROM certificat';
$requete = $conn->prepare($sqlQuery);
$requete->execute();
$res = $requete->fetchAll();
echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">reference<br> certificat </th>';
echo '<th scope="col">Nom </th>';
echo '<th scope="col">Description</th>';
echo '<th scope="col">Fichier pdf</th>';
echo '<th scope="col"></th>';
echo '<th scope="col"></th>';
echo '</tr></thead>';
foreach ($res as $c) {
    echo '<tbody><tr><td>' .
        $c['reference'] .
        '</td><td>' .
        $c['nom'] .
        '</td><td>' .
        $c['description'] .
        '</td><td>' .
        $c['fichier'] .
        '</td><td><form action="" method="POST">
        <input type="hidden" name="article_ref" value="' .
        $c['reference'] .
        '">
        <button type="submit" name="delete_article" class="btn btn-danger">Supprimer</button>
    </form>
    </td><td>
        <form action="../components/viewerC.php" method="GET">
    <input type="hidden" name="fichier" value="' .
        $c['fichier'] .
        '">
    <button type="submit" name="afficher_fichier" class="btn">Afficher</button>
</form>
        </td></tr></tbody>';
}
echo '</table><br><br>';
?>
    </div>
    <!-- Modal for confirmation -->
    <!-- <div class="wrapper fadeInDown">
        <div class="modal-content">
            <h2>Confirmation de suppression</h2>
            <p>Êtes-vous sûr de vouloir supprimer cet article?</p>
            <form action="" method="POST">
                <input type="hidden" id="article_ref" name="article_ref" value="">
                <button type="submit" name="delete_article" class="btn btn-danger">Supprimer</button>
                <button type="button" data-modal-close="#modal" class="btn btn-secondary">Annuler</button>
            </form>
        </div>
    </div> -->
    <script>
        // JavaScript function to set the article_id for deletion
        function setArticleRef(articleRef) {
            document.getElementById('article_ref').value = articleRef;
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