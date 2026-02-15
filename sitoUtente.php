<!DOCTYPE html>
<?php
    session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITO UTENTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <?php
        include "navbar.php";
    ?>
    <main class="row w-100">
        <div class="col-sm-3 colonneLaterali"></div>
        <section class="col-sm-6 mainSection">
            <h1>Ti sei loggato complimenti!!!</h1>
        </section>
        <div class="col-sm-3 colonneLaterali"></div>
    </main>
</body>
</html>