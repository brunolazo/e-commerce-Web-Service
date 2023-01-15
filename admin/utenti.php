<?php
    if(isset($_REQUEST['idCancellare'])){ 
      $id= mysqli_real_escape_string($con,$_REQUEST['idCancellare']??''); 
      $query="DELETE from utenti  where id='".$id."';"; 
      $res=mysqli_query($con,$query);
      if($res){
          ?>
          <div class="alert alert-warning float-right" role="alert">
              Utente cancellato con successo
          </div>
          <?php
      }else{
          ?>
          <div class="alert alert-danger float-right" role="alert">
              Errore al cancellare utente <?php echo mysqli_error($con); ?>
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
            <h1>Utenti</h1>
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
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>  <!-- nomi delle colonne della tabella -->
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Azioni
                    <a href="pannello.php?modulo=creareUtente"> <i class="fa fa-plus" aria-hidden="true"></i></a> <!-- quando si cliccherà sul simbolo del + , si verrà reinderizzati a pannello.php e al modulo verrà assegnato il valore creareUtente -->
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $query="SELECT  id,email,nome from utenti; "; //creazione query
                    $res=mysqli_query($con,$query); // ottengo il risultato della query
                    while( $row=mysqli_fetch_assoc($res) ) {//fintanto che il row contenga dei registri tramite questo ciclo verranno mostrati email e nome degli utenti
                    ?>                  
                      <tr>
                        <td><?php echo $row['nome'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td>
                          <a href="pannello.php?modulo=editareUtente&id=<?php echo $row['id'] ?>" style="margin-right: 25px"> <i class="fas fa-edit    "></i></a> <!-- quando si cliccherà sul simbolo per editare l'utente , si verrà reinderizzati a pannello.php e al modulo verrà assegnato il valore editareUtente -->
                          <a href="pannello.php?modulo=utenti&idCancellare=<?php echo $row['id'] ?>" class="text-danger cancellare"> <i class="fas fa-trash"></i> </a> <!-- quando si cliccherà sul simbolo per cancellare l'utente , si verrà reinderizzati a pannello.php, al modulo verrà assegnato il valore utenti e a idCancellare verrà assegnato l'id dell'utente da cancellare. al vincolo verrà assegnato come nome cancellare -->
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                </tbody>
              </table>
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