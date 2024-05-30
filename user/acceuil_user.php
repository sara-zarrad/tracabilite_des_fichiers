<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../js/rollbutton.js"></script>
    <script defer src="../js/rollbutton.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <script defer src="modelform.js"></script>
    <link href="../img/logo paf.png" rel="icon" />
    <link href="../css/dashboard.css" rel="stylesheet">
    <title>dashboard user</title>
</head>

<body>
    <div class="container_page">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">
                    <img src="../img/logo paf.png" height="60" alt="Logo">
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto" id="list">
                        <li class="nav-item">
                            <a class="nav-link" href="../components/user_logout.php">Deconnexion</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="button_div">
                <a class="nav-link" href="../user/ajouter_articleUser.php" target="_blank"><button class="fadeIn first" type="button">ajouter les
                        articles</button>
                </a>
                <a class="nav-link" href="../user/consulter_NormeUser.php"target="_blank"><button class="fadeIn first"
                        type="button">consulter les Normes</button>
                </a>
                <a class="nav-link" href="../user/consulter_Certifuser.php" target="_blank"><button class="fadeIn first"
                        type="button">consulter les certificats</button>
                </a>
                <a class="nav-link" href="../user/consulter_FicheReouser.php" target="_blank"><button class="fadeIn first"
                        type="button">consulter les fiches contrôles</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>