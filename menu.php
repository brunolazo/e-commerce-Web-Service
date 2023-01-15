<!-- Navbar -->
<nav class="navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link">Home</a>
        </li>
    </ul>
    <!-- barra di ricerca che chiama il modulo prodotti e gli passa il nome inserito nella barra di ricerca dall'utente -->
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" action="index.php">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar bg-gray" type="search" placeholder="Search" aria-label="Search" name="nome" value="<?php echo $_REQUEST['nome'] ?? ''; ?>">
            <input type="hidden" name="modulo" value="prodotti">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- icona di un carrello con un badge che indica il numero di prodotti diversi all'interno del carrello, cliccandolo mostrerà la lista di prodotti nel carrello -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="iconaCarrello">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                <span class="badge badge-danger navbar-badge" id="badgeProdotto"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="listaCarrello">

            </div>
        </li>
        <!-- icona del simbolo di un tente, cliccandolo mostrerà le opzioni per il l'accesso e la registrazione all'interno dell'ecommerce -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-user" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <?php
                if (isset($_SESSION['idCliente']) == false) {//se non è presente l'id del cliente =) mostrare dei collegamenti che rappresentino le opzioni per il login e per registrarsi
                ?>
                    <a href="login.php" class="dropdown-item">
                        <i class="fas fa-door-open mr-2 text-primary"></i>Accedi
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="registro.php" class="dropdown-item">
                        <i class="fas fa-sign-in-alt mr-2 text-primary"></i>Registrati
                    </a>
                <?php
                } else {//altrimenti mostrare un collegamento che rappresenti l'opzione per uscire dal proprio account
                ?>
                    <a href="index.php?modulo=utente" class="dropdown-item">
                        <i class="fas fa-user text-primary mr-2"></i>Ciao <?php echo $_SESSION['nomeCliente']; ?>
                    </a>
                    <form action="index.php" method="post">
                        <button name="azione" class="btn btn-danger dropdown-item" type="submit" value="chiudere">
                        <i class="fas fa-door-closed text-danger mr-2"></i>Chiudere sessione
                        </button>
                    </form>
                <?php
                }
                ?>
            </div>
        </li>
    </ul>
</nav>
<?php
//messaggio visualizzato quando un utente avrà fatto il login
$messaggio = $_REQUEST['messaggio'] ?? '';
if ($messaggio) {
?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <?php echo $messaggio; ?>
    </div>
<?php
}
?>