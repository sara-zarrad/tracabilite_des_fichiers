<?php
include '../components/connect_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reference = $_POST['Ref'];
    $nom = $_POST['nom'];
    $description = $_POST['desc'];
    $type = $_POST['type'];

    // Handle file upload
    $file_name = $_FILES['fichier']['name'];
    $file_tmp = $_FILES['fichier']['tmp_name'];
    move_uploaded_file(
        $file_tmp,
        '/path/to/your/upload/directory/' . $file_name
    );
    //insert into article
    $insert_query = $conn->prepare(
        'INSERT INTO articles (Reference, Type) VALUES (?, ?)'
    );
    $insert_query->execute([$reference, $type]);
    // Determine the table to insert based on the selected type
    switch ($type) {
        case 'N':
            $table = 'norme';
            header('location:../user/consulter_NormeUser.php');
            break;
        case 'C':
            $table = 'certificat';
            header('location:../user/consulter_Certifuser.php');
            break;
        case 'FR':
            $table = 'fiche_reponse';
            header('location:../user/consulter_FicheReouser.php');
            break;
        default:
            $table = '';
    }

    // Insert into the corresponding table
    if (!empty($table)) {
        $insert_query = $conn->prepare(
            "INSERT INTO $table (reference, nom, description, fichier) VALUES (?,? ,?,?)"
        );
        $insert_query->execute([$reference, $nom, $description, $file_name]);

        $message = 'Product added successfully!';
    } else {
        $error_message = 'Invalid product type selected!';
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
    <script src="../js/rollbutton.js"></script>
    <script defer src="../js/rollbutton.js"></script>
    <link href="../img/logo paf.png" rel="icon" />
    <link href="../css/creationutilisateur.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <title>Ajouter Articles</title>
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
                        <a class="nav-link" href="../user/acceuil_user.php">Page d'acceuil</a>
                    </li>
                    <li class="nav-item" id="nav-item">
                        <a class="nav-link" href="../components/user_logout.php">Deconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>
        <h4>
            Ajouter un article
        </h4>
        <div class="wrapper fadeInDown">
            <form action="" method="POST"  enctype="multipart/form-data" >
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" id="addon-wrapping">Reference</label>
                    <input type="text" class="form-control" placeholder="Reference" name="Ref" />
                </div>
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" />
                </div>
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" for="desc">Description</label>
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Description" />
                </div>
                <div class="input-group flex-nowrap">
                    <label class="input-group-text" for="type" id="type">Type d'article: </label>
                    <select class="form-control" id="type" name="type">
                        <option class="form-control" name="type" value="t">Choisir le type d'article</option>
                        <option class="form-control" name="type" value="N">Norme</option>
                        <option class="form-control" name="type" value="C">Certificat</option>
                        <option class="form-control" name="type" value="FR">Fiche Reponse</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="fichier">Télécharger le fichier :</label>
                    <input type="file" class="form-control" id="fichier" name="fichier">
                </div>
                <div id="formFooter">
                    <button type="submit">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>