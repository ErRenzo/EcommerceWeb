<?php
    require_once "dbparameter.php";
    class Prodotto {
        public $nomeProdotto;
        public $prezzo;
        public $quantita;
        public $username;

        function __construct($nomeProdotto, $prezzo, $quantita, $username) {
            $this->nomeProdotto = $nomeProdotto;
            $this->prezzo = $prezzo;
            $this->quantita = $quantita;
            $this->username = $username;
        }
    }
    function creaConessione(){
        global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS;

        $conn = new PDO(
            "mysql:host=$DB_HOST;dbname=$DB_NAME",
            $DB_USER,
            $DB_PASS
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    function insertUser($username, $mail, $password, $usertype) {
        try {
            $conn = creaConessione();
    
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $stmt = $conn->prepare(
                "INSERT INTO Users (Username, Mail, Password, Usertypeid)
                 VALUES (:username, :mail, :password, :usertype)"
            );
    
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':usertype', $usertype);
    
            $stmt->execute();
    
            return 0;
        } 
        catch (PDOException $e) {
            if ($e->getCode() === '23000') { // vincolo di integrità violato
                return 2;
            }
            return 1; // altri errori generici 
        }
    }

    function loginUser($username, $password) {
        try {
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "SELECT UserID, Password FROM Users WHERE Username = :username"
            );

            $stmt->bindParam(':username', $username);
            $stmt->execute();


            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return 2; // utente non trovato
            }elseif (password_verify($password, $row['Password'])) {
                $_SESSION["idUtente"] = $row['UserID'];
                return 0; // login corretto
            }
            
            return 3; // password errata

        } 
        catch (PDOException $e) {
            return 1; // errore generico
        }
    }
    function getUserType($username){
        try {
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "SELECT Usertypeid FROM Users WHERE Username = :username"
            );

            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['Usertypeid'];

        } 
        catch (PDOException $e) {
            return 0; // errore generico
        }
    }
    function aggiungiProdotto($nomeProdotto, $prezzo, $quantita, $userID){
        try {
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "INSERT INTO Prodotti (NomeProdotto, Prezzo, Quantita, UserID)
                VALUES (:nomeProdotto, :prezzo, :quantita, :userID)"
            );

            $stmt->bindParam(':nomeProdotto', $nomeProdotto);
            $stmt->bindParam(':prezzo', $prezzo);
            $stmt->bindParam(':quantita', $quantita);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();

            return 0; 
        } 
        catch (PDOException $e) {
            if ($e->getCode() === '23000') { // vincolo di integrità violato
                return 2;
            }
            return 1; // altri errori generici 
        }
    }
    function visualizzaProdotti(){
        try{
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "SELECT p.NomeProdotto, p.Prezzo, p.Quantita, u.Username 
                FROM prodotti AS p INNER JOIN users AS u ON p.UserID = u.UserID"
            );

            $stmt->execute();
            $prodotti = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $prodotti[] = new Prodotto($row['NomeProdotto'], $row['Prezzo'], $row['Quantita'], $row['Username']);
            }
            return $prodotti;
        }
        catch (PDOException $e){
            return;
        }
    }
    function cercaUtente($userID){
        try{
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "SELECT Username FROM users WHERE UserID = :userID"
            );

            $stmt->bindParam(':userID', $userID);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['Username'];
        }
        catch (PDOException $e){
            return;
        }
    }
    function filtra_prezzi($tipoOrdine){
        try{
            $conn = creaConessione();

            if($tipoOrdine == 1){ // Per ordine crescente
                $stmt = $conn->prepare(
                    "SELECT p.NomeProdotto, p.Prezzo, p.Quantita, u.Username 
                    FROM prodotti AS p INNER JOIN users AS u ON p.UserID = u.UserID 
                    ORDER BY p.Prezzo ASC"
                );
    
                $stmt->execute();
    
                $prodotti = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $prodotti[] = new Prodotto($row['NomeProdotto'], $row['Prezzo'], $row['Quantita'], $row['Username']);
                }
                return $prodotti;
            }
            else{ // Per ordine descrescente
                $stmt = $conn->prepare(
                    "SELECT p.NomeProdotto, p.Prezzo, p.Quantita, u.Username 
                    FROM prodotti AS p INNER JOIN users AS u ON p.UserID = u.UserID 
                    ORDER BY p.Prezzo DESC"
                );
    
                $stmt->execute();
    
                $prodotti = [];
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $prodotti[] = new Prodotto($row['NomeProdotto'], $row['Prezzo'], $row['Quantita'], $row['Username']);
                }
                return $prodotti;
            }
        }
        catch (PDOException $e){
            return;
        }
    }
    function filtra_nomiProdotti($nomeProdotto){
        try{
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "SELECT p.NomeProdotto, p.Prezzo, p.Quantita, u.Username 
                FROM prodotti AS p INNER JOIN users AS u ON p.UserID = u.UserID 
                WHERE p.NomeProdotto LIKE :nomeProdotto;"
            );
            
            $nomeCercato = "%" . $nomeProdotto . "%";
            $stmt->bindParam(':nomeProdotto', $nomeCercato);
            $stmt->execute();

            $prodotti = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $prodotti[] = new Prodotto($row['NomeProdotto'], $row['Prezzo'], $row['Quantita'], $row['Username']);
            }
            return $prodotti;
        }
        catch(PDOException $e){
            return;
        }
    }
    function filtra_venditori($nomeVenditore){
        try{
            $conn = creaConessione();

            $stmt = $conn->prepare(
                "SELECT p.NomeProdotto, p.Prezzo, p.Quantita, u.Username 
                FROM prodotti AS p INNER JOIN users AS u ON p.UserID = u.UserID 
                WHERE u.Username LIKE :nomeVenditore;"
            );
            
            $nomeCercato = "%" . $nomeVenditore . "%";
            $stmt->bindParam(':nomeVenditore', $nomeCercato);
            $stmt->execute();

            $prodotti = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $prodotti[] = new Prodotto($row['NomeProdotto'], $row['Prezzo'], $row['Quantita'], $row['Username']);
            }
            return $prodotti;
        }
        catch(PDOException $e){
            return;
        }
    }
?>