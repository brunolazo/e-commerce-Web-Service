<!DOCTYPE html>
<html>
  <?php
    include_once "dbecommerce.php"; //mi connetto alla base di dati
    $con=mysqli_connect($host,$user,$pass,$db); //inizializzo la connessione
    session_start(); //inizializzo la sessione
    session_regenerate_id(true); // il php session id permtte la connessione tra il server contenente i dati dell'account e il browser dell'utente. questo id verrà aggiornato ogni volta che l'utente cambi pagina, e i vecchi id di sessione verranno cancellti in modo t.c. se ci fosse un attacco di tipo man in the middle e questo id venisse intercettato =) non sarebbe più un id valido 
    if( isset($_REQUEST['sessione']) && $_REQUEST['sessione']=="chiudere" ){ //verificare che sia stato cliccato il pulsante per chiudere la sessione
      session_destroy(); //chiudo la sessione
      header("location: index.php"); //reindirizzo all' index
    }
    //per evitare che qualcuno entri nel pannello senza aver fatto il login
    if( isset($_SESSION['id'])==false) { //se la variabile di sessione id non è presente
      header("location: index.php"); //allora lo reindirizzo all'index 
    }
    $modulo=$_REQUEST['modulo']??'';
  ?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bruno's Watch Collection</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
 <!-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css"> -->
  
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
 <!-- <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">-->
<link rel="stylesheet" href="css/editor.dataTables.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
        <a class="nav-link" href="pannello.php?modulo=editareUtente&id=<?php echo $_SESSION['id']; ?>">
          <i class="far fa-user"></i>
        </a>
        <a class="nav-link text-danger" href="pannello.php?modulo=&sessione=chiudere" title="Chiudere sessione" > <!-- cliccando sull'icona alla variabile sessione verrà assegnato il valore chiudere -->
            <i class="fas fa-door-closed    "></i>
        </a>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="images/1.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Bruno's Watch Collection</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nome']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="fa fa-shopping-cart nav-icon" aria-hidden="true"></i>
              <p>
                Ecommerce
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pannello.php?modulo=statistiche" class="nav-link <?php echo ($modulo=="statistiche" || $modulo=="")?" active ": " "; ?>">  <!-- quando cliccato al parametro modulo verrà assegnato il valore statistiche //la parte dopo serve a colorare la scheda quando viene cliccata-->
                  <i class="fas fa-chart-bar  nav-icon  "></i>
                  <p>Statistiche</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pannello.php?modulo=utenti" class="nav-link <?php echo ($modulo=="utenti" || $modulo=="creareUtente" || $modulo=="editareUtente")?" active ": " "; ?>">  <!-- ... -->
                  <i class="far fa-user nav-icon"></i>
                  <p>Utenti</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pannello.php?modulo=prodotti" class="nav-link <?php echo ($modulo=="prodotti")?" active ": " "; ?>"> <!-- ... -->
                  <i class="fa fa-shopping-bag nav-icon" aria-hidden="true"></i>
                  <p>Prodotti</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pannello.php?modulo=vendite" class="nav-link <?php echo ($modulo=="vendite")?" active ": " "; ?>"> <!-- ... -->
                  <i class="fa fa-table nav-icon" aria-hidden="true"></i>
                  <p>Vendite</p>
                </a>
              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <?php
  if(isset($_REQUEST['messaggio'])){
  ?>
    <div class="alert alert-primary alert-dismissible fade show float-right" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      <?php echo $_REQUEST['messaggio'] ?>
    </div>
  <?php
  }
    if($modulo=="statistiche" || $modulo==""){ //se la variabile modulo è = a statische o è vuoto allora andrà nella pagina delle statistiche
      include_once "statistiche.php";
    }
    if($modulo=="utenti"){
      include_once "utenti.php";
    }
    if($modulo=="prodotti"){
      include_once "prodotti.php";
    }
    if($modulo=="vendite"){
      include_once "vendite.php";
    }
    if($modulo=="creareUtente"){
      include_once "creareUtente.php";
    }
    if($modulo=="editareUtente"){
      include_once "editareUtente.php";
    }
    if($modulo=="prodotti"){
      include_once "prodotti.php";
    }
  ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<!-- <script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> -->

<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<!-- <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script> -->
<script src="js/dataTables.editor.min.js"></script>

<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
    editor = new $.fn.dataTable.Editor( {
        ajax: "controllers/prodotti.php",
        table: "#tabellaProdotti",
        fields: [ {
                label: "Nome:",
                name: "nome"
            }, {
                label: "Prezzo:",
                name: "prezzo"
            }, {
                label: "Quantita:",
                name: "quantita"
            }, {
                label: "Immagini:",
                name: "files[].id", //nome di campo
                type: "uploadMany", //sarà possibile caricare multiple immagini
                display: function ( fileId, counter ) { //caratteristiche dell'immagine mostrata
                    return '<img src="'+editor.file( 'files', fileId ).web_path+'"/>';
                },
                noFileText: 'Non ci sono immagini'
            }, {
                label: "Descrizione:",
                name: "descrizione"
            }
        ]
    } );
 
    $('#tabellaProdotti').DataTable( {
        dom: "Bfrtip",
        ajax: "controllers/prodotti.php",
        columns: [
            { data: "nome" },
            { data: "prezzo", render: $.fn.dataTable.render.number( ',', '.', 0, '€' ) },
            { data: "quantita" },
            {
                data: "files", 
                render: function ( d ) { 
                    return d.length ?
                        d.length+' immagine/i' :
                        'Non ci sono immagini';
                },
                title: "Immagine"
            },
            { data: "descrizione" }
        ],
        select: true,
        buttons: [
            { extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor }
        ]
    } );  
  });
</script>
<script>
  $(document).ready(function () {
    $(".cancellare").click(function (e) { 
      e.preventDefault();
      var res=confirm("Vuoi procedere a cancellare questo utente?");
      if(res==true){
        var link=$(this).attr("href");
        window.location=link;
      }

    });
  });
</script>
</body>
</html>
