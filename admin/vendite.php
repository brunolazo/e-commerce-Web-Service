  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vendite</h1>
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
                  <th>Id vendita</th>
                  <th>Id prodotto</th>
                  <th>Quantita</th>
                  <th>Prezzo unità</th>
                  <th>Prezzo totale</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $query="SELECT id_prodotto,id_vendita,quantita,prezzo,totale from dettagli_vendite; "; 
                    $res=mysqli_query($con,$query); 
                    while( $row=mysqli_fetch_assoc($res) ) {
                    ?>                  
                      <tr>
                        <td><?php echo $row['id_vendita'] ?></td>
                        <td><?php echo $row['id_prodotto'] ?></td>
                        <td><?php echo $row['quantita'] ?></td>
                        <td><?php echo $row['prezzo'] ?></td>
                        <td><?php echo $row['totale'] ?></td>
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