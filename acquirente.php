<!DOCTYPE html>
<?php
    session_start();
    require_once "database.php";
    $nomeVenditore = cercaUtente($_SESSION["idUtente"]);
    $message = "";
    $prodotti = [];
    if(isset($_GET["azione"]))
    {
        switch ($_GET["azione"]) {
            case "visualizza":
                $prodotti = visualizzaProdotti();
                break;
            case "filtra_nomiProdotti":
                $prodotti = filtra_nomiProdotti($_GET["nomeProdotto"]);
                break;
            case "filtra_venditori":
                $prodotti = filtra_venditori($_GET["nomeVenditore"]);
                break;
            case "filtra_prezzi":
                $prodotti = filtra_prezzi($_GET["tipoOrdine"]);
                break;
        }
        if(!$prodotti)
        {
            $message = "Si è verificato un errore";
        }
    }
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
        <section class="col-sm-8 mainSectionAcquirente">
            <h1>Benvenuto <?php echo $nomeVenditore; ?>!</h1>
            <h1>Complimenti sei ora un acquirente!</h1>
            <div class="separatore"></div>
            <div class="visualProdotti">
                <h1>Visualizza i prodotti acquistabili</h1>
                <form action="" method="GET">
                    <input type="hidden" name="azione" value="visualizza">
                    <button type="submit">Visualizza</button>
                </form>
                <div style="font-size: 30px"> <?php echo $message; ?> </div>
            </div>
            <div class="separatore"></div>
            <h1>Filtra i prodotti</h1>
            <div class="tabellaFiltri row w-100 mt-5">
                <div class='col-sm-4'>
                    <h6>In base al nome dei prodotti</h6>
                    <form action="" method="GET">
                        <input type="hidden" name="azione" value="filtra_nomiProdotti">
                        <input type="text" name="nomeProdotto" placeholder="Il nome del prodotto">
                        <button type="submit">Cerca</button>
                    </form>
                </div>
                <div class='col-sm-4'>
                    <h6>In base ai venditori</h6>
                    <form action="" method="GET">
                        <input type="hidden" name="azione" value="filtra_venditori">
                        <input type="text" name="nomeVenditore" placeholder="Il nome del venditore">
                        <button type="submit">Cerca</button>
                    </form>
                </div>
                <div class='col-sm-4'>
                    <h6>In base al prezzo</h6>
                    <form action="" method="GET">
                        <input type="hidden" name="azione" value="filtra_prezzi">
                        <select name="tipoOrdine" required>   
                            <option value="">-- Seleziona --</option>
                            <option value="1">Crescente</option>
                            <option value="2">Descrescente</option>
                        </select>
                        <button type="submit">Ordina</button>
                    </form>
                </div>
            </div>
            <div class="separatore"></div>
            <div class="tabellaProdotti row w-100">
                <?php
                if($prodotti)
                {
                    for ($i = 0; $i < count($prodotti); $i++){
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
                ?>
            </div>
        </section>
        <div class="col-sm-2 colonneLaterali"></div>
    </main>
</body>
</html>