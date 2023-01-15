<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bruno's Watch Collection</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Bruno's </b>Watch Collection</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Effettua il login</p>
<!-- blocco php per ricevere email,password e nel caso venga cliccato il pulsante Login si procede con il log in -->
<?php
  if( isset($_REQUEST['login']) ){ //se si clicca sul pulsante login
    session_start();
    $email=$_REQUEST['email']??'';//si memorizza la email in una variabile e nel caso non venga inserito nessun dato verrà memorizzata una stringa vuota
    $password=$_REQUEST['pass']??'';//...
    $password=md5($password);//password crittografata in md5
    // questi dati andranno poi confrontati con quelli presenti nella base di dati, sarà necessario connettermi alla base di dati e quindi creare una connessione tramite i dati di connessione =) creare nuovo file db:ecommerce.php
    include_once "admin/dbecommerce.php";
    $con=mysqli_connect($host,$user,$pass,$db);//inizializzo la connessione
    $query="SELECT  id,email,nome from clienti where email='" . $email . "' and pass='" . $password . "' "; //creazione query dove ottengo l'id dalla tabella clienti nel caso la email e la password nella base di dati siano gli stessi che l'utente ha inserito nel form
    $res=mysqli_query($con,$query); // ottengo il risultato della query
    $row=mysqli_fetch_assoc($res); // ottengo il registro oppure un valore nullo
    if ($row){ //se il registro contiene dati all'interno di esso =)
      $_SESSION['idCliente']=$row['id'];
      $_SESSION['emailCliente']=$row['email'];
      $_SESSION['nomeCliente']=$row['nome'];
      header("location: index.php?messaggio=Utente ha effettuato login con successo");
    }
    else{//altrimenti invio una allerta
?>
  <div class="alert alert-danger" role="alert">
    Errore nel login
  </div>
<?php
    }

  }
?>
      <form method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pass">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary" name="login">Login</button> <!-- pulsante per procedere con il login -->
            <a href="registro.php" class="text-success float-right" >Registrati</a> <!-- collegamento per effettuare il login -->
          </div>
          <!-- /.col -->
        </div>
      </form>


    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.min.js"></script>

</body>
</html>
