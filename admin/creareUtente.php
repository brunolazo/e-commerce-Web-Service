   <?php
      if( isset($_REQUEST['salvare'])){ 
         
         $email= mysqli_real_escape_string($con,$_REQUEST['email']??'');
         $pass= md5(mysqli_real_escape_string($con,$_REQUEST['pass']??'')); 
         $nome= mysqli_real_escape_string($con,$_REQUEST['nome']??'');
         
         $query="INSERT INTO utenti
         (email,pass,nome) VALUES
         ('".$email."','".$pass."','".$nome."')
         "; 
         $res=mysqli_query($con,$query); 
         if($res){ 
            echo '<meta http-equiv="refresh" content="0; url=pannello.php?modulo=utenti&messaggio=Utente creato con successo" /> ';
         }
         else{ 
            ?>
            <div class="alert alert-danger" role="alert">
               Errore al creare utente  <?php echo mysqli_error($con); ?>
            </div>
            <?php
         }
      }
   ?>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Creare utente</h1>
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
               <form action="pannello.php?modulo=creareUtente" method="post"> 
                  <div class="form-group">
                    <label >Email</label>
                    <input type="email" name="email" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label >Password</label>
                    <input type="password" name="pass" class="form-control" required="required">
                  </div>
                  <div class="form-group">
                    <label >Nome</label>
                    <input type="text" name="nome" class="form-control" required="required">
                  </div>
                  <div class="form-group">
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