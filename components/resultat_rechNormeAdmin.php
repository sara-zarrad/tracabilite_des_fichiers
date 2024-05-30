<?php
include '../components/connect_bd.php';

// Check if the reference is provided in the URL
if (isset($_GET['reference'])) {
    $search_reference = $_GET['reference'];

    // Perform a search query using the provided reference
    $search_query = $conn->prepare(
        'SELECT * FROM norme WHERE reference LIKE :search_reference'
    );
    $search_query->execute([
        'search_reference' => '%' . $search_reference . '%',
    ]);

    // Fetch and display the results
    $res = $search_query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../js/rollbutton.js"></script>
    <script defer src="../js/rollbutton.js"></script>
    <link href="../tracabilite/img/logo paf.png" rel="icon" />
    <link href="../css/creationutilisateur.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <title>resultat recherche </title>
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
                        <form class="search-form" action="../components/resultat_rech.php">
                        <input type="text" placeholder="rechercher par ref" name="reference" />
                    </form>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../admin/dashboard_admin.php">Page d'acceuil</a>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../components/admin_logout.php">Deconnexion</a>                    
                    </li>
                </ul>
            </div>
        </nav>
        <h2>resultat recherche</h2>
        <?php if (count($res) > 0) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col">reference Norme </th>';
            echo '<th scope="col">Nom </th>';
            echo '<th scope="col">Description</th>';
            echo '<th scope="col">Fichier pdf</th>';
            echo '<th scope="col"></th>';
            echo '<th scope="col"></th>';
            echo '</tr></thead>';
            foreach ($res as $res) {
                echo '<tbody><tr><td>' .
                    $res['reference'] .
                    '</td><td>' .
                    $res['nom'] .
                    '</td><td>' .
                    $res['description'] .
                    '</td><td>' .
                    $res['fichier'] .
                    '</td><td>
                <form action="" method="POST">
            <input type="hidden" name="article_ref" value="' .
                    $res['reference'] .
                    '">
            <button type="submit" name="delete_article" class="btn btn-danger">Supprimer</button>
        </form>
        </td><td>
        <form action="../components/viewerN.php" method="GET">
    <input type="hidden" name="fichier" value="' .
                    $res['fichier'] .
                    '">
    <button type="submit" name="afficher_fichier" class="btn">Afficher</button>
</form>
        </td></tr></tbody></table>';
            }
        } ?>
    </div>
</body>
</html>