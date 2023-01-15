<?php
  if( isset($_REQUEST['salvare'])){ 
      
      $email= mysqli_real_escape_string($con,$_REQUEST['email']??'');
      $pass= md5(mysqli_real_escape_string($con,$_REQUEST['pass']??'')); 
      $nome= mysqli_real_escape_string($con,$_REQUEST['nome']??'');
      $id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? '');
      
      $query="UPDATE utenti SET
        email='" . $email . "',pass='" . $pass . "',nome='" . $nome . "'
        where id='".$id."';
      ";
      $res=mysqli_query($con,$query); 
      if($res){ 
        echo '<meta http-equiv="refresh" content="0; url=pannello.php?modulo=utenti&messaggio=Utente '.$nome.' aggiornato con successo" /> ';
      }
      else{ 
        ?>
        <div class="alert alert-danger" role="alert">
            Errore all'aggiornare utente  <?php echo mysqli_error($con); ?>
        </div>
        <?php
      }
  }
  $id= mysqli_real_escape_string($con,$_REQUEST['id']??''); //per sanitizzare l'id ho utilizzato la funzione mysqli_real_escape_string()
  $query="SELECT id,email,pass,nome from utenti where id='".$id."'; ";//creazione query dove ottengo l'id, email, password, nome dalla tabella utenti nel caso l'id nella base di dati sia uguale a quello nella variabile
  $res=mysqli_query($con,$query); // ottengo il risultato della query 
  $row=mysqli_fetch_assoc($res); // ottengo il registro associato alla query
?>   
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Modificare utente</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
              <form action="pannello.php?modulo=editareUtente" method="post"> 
                <div class="form-group">
                <!-- Nel campo email e password verrà inserito nel registro row riguardante il corripsettivo campo; e per tutti i campi sarà obbligatoria la compilazione-->
                  <label >Email</label> 
                  <input type="email" name="email" class="form-control" value="<?php echo $row['email'] ?>" required="required" >
                </div>
                <div class="form-group">
                  <label >Pass</label>
                  <input type="password" name="pass" class="form-control"  required="required" >
                </div>
                <div class="form-group">
                  <label >Nome</label>
                  <input type="text" name="nome" class="form-control" value="<?php echo $row['nome'] ?>"  required="required" >
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>" > <!-- memorizzerà l'id --> 
                    <button type="submit" class="btn btn-primary" name="salvare">Salvare</button>
                </div>
              </form>
            </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>