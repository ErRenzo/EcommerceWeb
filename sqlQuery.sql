CREATE TABLE UserTypes (
    Usertypeid INT AUTO_INCREMENT PRIMARY KEY,
    Type VARCHAR(50) NOT NULL,
    Description VARCHAR(255)
);

CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Mail VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Usertypeid INT NOT NULL,
    FOREIGN KEY (Usertypeid) REFERENCES UserTypes(Usertypeid)
);

CREATE TABLE Prodotti(
    ProdottoID INT AUTO_INCREMENT PRIMARY KEY,
    NomeProdotto VARCHAR(50) NOT NULL UNIQUE,
    Prezzo FLOAT NOT NULL,
    Quantita INT NOT NULL,
    UserID INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

INSERT INTO UserTypes (type, description)
VALUES 
    ('Administrator', 'Ruolo dell\'amministratore con pieni privilegi di gestione del sistema.'),
    ('Seller', 'Ruolo del venditore che gestisce i prodotti e le vendite.'),
    ('Buyer', 'Ruolo dell\'acquirente che effettua acquisti e visualizza prodotti disponibili.');   