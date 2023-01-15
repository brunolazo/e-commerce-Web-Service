<?php
//query che conta quante vendite ci sono state negli ultimi 7 giorni
$queryNumVendite="SELECT COUNT(id) AS num from vendite 
where data BETWEEN DATE( DATE_SUB(NOW(),INTERVAL 7 DAY) ) AND NOW(); ";
$resNumVendite=mysqli_query($con,$queryNumVendite);//risultato query
$rowNumVendite=mysqli_fetch_assoc($resNumVendite);//registro nel quale verrà memorizzato il risultato del query
//query che conta quanti sono i clienti
$queryNumClienti="SELECT COUNT(id) AS num from clienti; ";
$resNumClienti=mysqli_query($con,$queryNumClienti);
$rowNumClienti=mysqli_fetch_assoc($resNumClienti);
//query che restituirà il prezzo totale delle vendite per ogni giorno
$queryVenditeGiorno="SELECT
sum(dettagli_vendite.totale) as total,
vendite.data
FROM
vendite
INNER JOIN dettagli_vendite ON dettagli_vendite.id_vendita = vendite.id
GROUP BY DAY(vendite.data);";
$resVenditeGiorno=mysqli_query($con,$queryVenditeGiorno);
$labelVendite="";
$datiVendite="";

while($rowVenditeGiorno=mysqli_fetch_assoc($resVenditeGiorno)){
  $labelVendite=$labelVendite."'". date_format(date_create($rowVenditeGiorno['data']),"Y-m-d")."',"; //variabile che conterrà l'anno, mese e giorno dei giorni in cui sono state effettuate le vendite
  $datiVendite=$datiVendite.$rowVenditeGiorno['total'].","; //variabile che conterrà il cosot totale dei giorni in cui ci sono state vendite
}
$labelVendite=rtrim($labelVendite,",");
$datiVendite=rtrim($datiVendite,",");
?> 
<script>
  var labelVendite=[<?php echo $labelVendite; ?>];
  var datiVendite=[<?php echo $datiVendite; ?>];
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Statistiche</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <h3><?php echo $rowNumVendite['num']; ?></h3>
                  <p>Vendite negli ultimi 7 giorni</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                  <h3><?php echo $rowNumClienti['num'] ?></h3>
                  <p>Clienti</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Vendite al giorno
                </h3>
                </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>