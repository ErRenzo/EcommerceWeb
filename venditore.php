<!DOCTYPE html>
<?php
    session_start();
    require_once "database.php";
    $nomeVenditore = cercaUtente($_SESSION["idUtente"]);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITO UTENTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
        include "navbar.php";
    ?>
    <main class="row w-100">
        <div class="col-sm-2 colonneLaterali"></div>
        <section class="col-sm-8 mainSectionVenditore">
            <h1 class="titoloVenditore typingTesto">Benvenuto <?php echo $nomeVenditore; ?>!</h1>
            <h1>Complimenti sei ora un venditore!</h1>
            <div class="separatore"></div>
            <div class="aggiuntaProdotti">
                <h1>Aggiungi il prodotto</h1>
                <form action="" method="POST">
                    <input type="text" name="nomeProdotto" placeholder="Il nome del prodotto">
                    <input type="text" name="prezzo" placeholder="Il prezzo">
                    <input type="text" name="quantita" placeholder="La quantita">
                    <button type="submit" class="stileButton">Invia</button>
                </form>
                <br>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") 
                    {
                        if (isset($_POST["nomeProdotto"]) && isset($_POST["prezzo"]) && isset($_POST["quantita"])) 
                        {
                            $result = aggiungiProdotto($_POST["nomeProdotto"], $_POST["prezzo"], $_POST["quantita"], $_SESSION["idUtente"]);
                            if($result == 0)
                            {
                                $message = "Inserimento avvenuto con successo!";
                            }
                            elseif($result == 1)
                            {
                                $message = "Errore";
                            }
                            else
                            {
                                $message = "Il nome del prodotto è già presente nel database";
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
            </div>
            <div class="separatore"></div>
            <div class="visualProdotti">
                <h1>Visualizza i tuoi prodotti</h1>
                <form action="" method="GET">
                    <button type="submit" class="stileButton" style="width: 110%; text-align: center;">Visualizza i prodotti</button>
                </form>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] === "GET") 
                    {
                        $message = "";
                        $prodotti = visualizzaProdotti();
                        if(!$prodotti)
                        {
                            $message = "Si è verificato un errore";
                ?>
                <div style="font-size: 30px"> 
                <?php        
                            echo $message;
                        }
                        else
                        {
                ?>
                </div>
            </div>
            <div class="separatore"></div>
            <div class="tabellaProdotti row w-100">
                <?php
                            for ($i = 0; $i < count($prodotti); $i++){
                                if($prodotti[$i]->username === $nomeVenditore)
                                {
                ?>
                <div class='col-sm-4'>
                    <div class='card'>
                    <div class='card-body'>
                        <h4 class='card-title'> <?php echo $prodotti[$i]->nomeProdotto; ?> </h4>
                        <p class='card-text'><em>Quantità: <?php echo $prodotti[$i]->quantita; ?> </em><p>
                        <p class='card-text'><em>Venditore: <?php echo $prodotti[$i]->username; ?> </em><p>
                        <button type='button' class='btn btn-secondary'><p class='card-text'><strong> <?php echo $prodotti[$i]->prezzo; ?> </strong></p></button>
                    </div>
                    </div>
                </div>
                <?php
                                }
                            }
                        }
                    }
                ?>
            </div>
            <div class="separatore"></div>
        </section>
        <div class="col-sm-2 colonneLaterali"></div>
    </main>
</body>
</html>