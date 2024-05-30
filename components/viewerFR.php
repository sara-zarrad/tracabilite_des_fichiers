
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../img/logo paf.png" rel="icon" />
    <title>fichier</title>
</head>

<body>
<?php
include '../components/connect_bd.php';

session_start();

if (isset($_GET['fichier'])) {
    // Get the value of 'fichier' from the URL parameter
    $fichier = $_GET['fichier'];
    try {
        // Prepare and execute the SQL query
        $select_query = $conn->prepare(
            'SELECT fichier FROM fiche_reponse WHERE fichier = ?'
        );
        $select_query->execute([$fichier]);

        // Fetch the result
        $result = $select_query->fetch(PDO::FETCH_ASSOC);

        // Check if a record was found
        if ($result) {
            // The file name is stored in $result['fichier']
            $file_name = $result['fichier'];

            // Specify the base file path (adjust the base path as needed)
            $base_path = '../fichier';

            // Specify the full file path
            $file_path = $base_path . '/' . $file_name;

            // Check if the file exists
            if (file_exists($file_path)) {
                // Output the PDF using the <embed> tag
                echo '<embed src="' .
                    $file_path .
                    '" type="application/pdf" width="100%" height="600px" />';
            } else {
                echo 'File not found!';
            }
        } else {
            echo 'Record not found.';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'File parameter not provided.';
}
?>
</body>

</html>
