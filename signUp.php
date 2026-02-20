<!DOCTYPE html>
<?php
    session_start();
    require_once "database.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRATI</title>
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
            <h1 class="titoloSignup typingTesto">MODULO DI REGISTRO</h1>
            <br>
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Il tuo nome">
                <input type="text" name="mail" placeholder="La tua mail">
                <input type="password" name="password" placeholder="La tua password">
                <select name="usertype" required>   
                    <option value="">-- Seleziona --</option>
                    <option value="1">Amministratore</option>
                    <option value="2">Venditore</option>
                    <option value="3">Acquirente</option>
                </select>
                <button type="submit" class="stileButton">Invia</button>
            </form>
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $message="Errore";
                    
                    if(isset($_POST["username"]) && isset($_POST["mail"]) && isset($_POST["password"])){

                        $result = insertUser($_POST["username"],$_POST["mail"],$_POST["password"],$_POST["usertype"]);
                        
                        if($result==0)
                        {
                            $message="Inserimento avvenuto con successo";
                        }
                        elseif ($result==2)
                        {
                            $message="Username o Mail già presenti nel database";
                        }
                        else{
                            $message="Errore";
                        }
                    }

            ?>
            <div style="font-size: 30px"> 
            <?php        
                    echo $message;
                } 
            ?>
            </div>
            <br>
        </section>
        <div class="col-sm-3 colonneLaterali"></div>
    </main>
</body>
</html>