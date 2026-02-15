<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["logUtente"])) 
    {
        $_SESSION["logUtente"] = false;
    }
    require_once "database.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
        include "navbar.php";
    ?>
    <main class="row w-100">
        <div class="col-sm-3 colonneLaterali"></div>
        <section class="col-sm-6 mainSection">
            <br>
            <h1>MODULO DI LOGIN</h1>
            <br>
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Il tuo nome">
                <input type="password" name="password" placeholder="La tua password">
                <button type="submit">Invia</button>
            </form>
            <br>
            <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $message = "";
                    if (isset($_POST["username"]) && isset($_POST["password"])) {

                        $result = loginUser($_POST["username"], $_POST["password"]);

                        if ($result === 0){
                            $_SESSION["username"] = $_POST["username"];
                            $message = "login riuscito";
                            $_SESSION["logUtente"] = true;
                            $typeUser = getUserType($_POST["username"]);
                            if($typeUser == 1)
                            {
                                header("Location: amministratore.php");
                            }
                            else if($typeUser == 2)
                            {
                                header("Location: venditore.php");
                            }
                            else // $typeUser == 3
                            {
                                header("Location: acquirente.php");
                            }
                            die();
                        } 
                        elseif ($result === 2){
                            $message = "Utente non trovato";
                        } 
                        elseif ($result === 3){
                            $message = "Password errata";
                        }
                        else{
                            $message = "Errore nella connessione con il DB"; 
                        }
                    }
                    echo "<div style='font-size:30px'>$message</div>";
                }
            ?>
            <br>
        </section>
        <div class="col-sm-3 colonneLaterali"></div>
    </main>
</body>
</html>