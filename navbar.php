<link rel="stylesheet" href="stile.css">
<div class="headLine">
  <img src="Immagini/blackEagle.webp">
</div>
<nav class="navbar navbar-expand-sm Pbg-darkGradient navbar-dark">
  <div class="container-fluid justify-content-center">
    <ul class="navbar-nav">
      <?php
        if($_SESSION["logUtente"] == false){
      ?>
        <li class="nav-item">
          <a class="nav-link stilePaNavbar" href="login.php">LOGIN</a>
        </li>
        <li class="nav-item">
          <a class="nav-link stilePaNavbar" href="signUp.php">REGISTRATI</a>
        </li>
      <?php
        }
        else{
      ?>
        <li class="nav-item">
          <a class="nav-link stilePaNavbar" href="logout.php">LOGOUT</a>
        </li>
      <?php    
        }
      ?>
    </ul>
  </div>
</nav>