<!-- lista dei prodotti -->
<div class="row mt-1"><!-- aggiunta di un nuovo registro -->
   <?php
   $where="where 1=1";
   $nome= mysqli_real_escape_string($con,$_REQUEST['nome']??''); //per sanitizzare la variabile nome ho utilizzato la funzione mysqli_real_escape_string()
   if( empty($nome)==false ){ //se il nome non è vuoto =) la condizione di where sarà tale che la query restituisca i prodotti che hanno un nome che corrisponde a quello inserito
      $where="where nome like '%".$nome."%'";
   }
   $queryConto="SELECT COUNT(*) as conto FROM prodotti $where;"; //query che conterà la quantità di prodotti  
   $resConto=mysqli_query($con,$queryConto);// ottengo il risultato della query
   $rowConto=mysqli_fetch_assoc($resConto);// ottengo il registro
   $totaleElementi=$rowConto['conto'];//quantità di prodotti trovati
   $elementiPerPagina=6;
   $totalePagine=ceil($totaleElementi/$elementiPerPagina);
   $paginaSel=$_REQUEST['pagina']??false;//se è presente il paramentro pagina =) la pagina verrà memorizzata in paginaSel altrimenti verrà memorizzato un false
   if($paginaSel==false){//se non è selezionata nessuna pagina in automatico verrà selezionata la prima
      $inizioLimite=0; //variabile che indicherà a partire da quale elemento iniziare a mostrare i successivi elementiPerPagina
      $paginaSel=1;
   }else{
      $inizioLimite=($paginaSel-1)* $elementiPerPagina;
   }
   $limite=" limit $inizioLimite,$elementiPerPagina ";
   
   $query = "SELECT 
      p.id,
      p.nome,
      p.prezzo,
      p.quantita,
      f.web_path
      FROM
      prodotti AS p
      INNER JOIN prodotti_files AS pf ON pf.prodotto_id=p.id
      INNER JOIN files AS f ON f.id=pf.file_id
      $where
      GROUP BY p.id
      $limite
      ";
   $res = mysqli_query($con, $query);
   while ($row = mysqli_fetch_assoc($res)) { 
   ?>
      <div class="col-lg-4 col-md-6 col-sm-12">  
         <div class="card border-primary">
            <img class="card-img-top img-thumbnail" src="<?php echo $row['web_path'] ?>" alt="">
            <div class="card-body">
               <h2 class="card-title"><strong><?php echo $row['nome'] ?></strong></h2>
               <p class="card-text"><strong>Prezzo:</strong><?php echo $row['prezzo'] ?></p>
               <p class="card-text"><strong>Quantita:</strong><?php echo $row['quantita'] ?></p>
               <a href="index.php?modulo=dettagliprodotto&id=<?php echo $row['id'] ?>" class="btn btn-primary" >Dettagli</a> 
            </div>
         </div>
      </div>
   <?php
   }
   ?>
</div>
<?php
if($totalePagine>0){ // se sono presenti più pagine =) crea un Navigatore di Pagine
?>
   <nav aria-label="Page navigation">
      <ul class="pagination">
      <?php
            if( $paginaSel!=1 ){ //se la pagina selezionata è diversa da 1 =) sarà possibile mostrare la sezione precedente nel navigatore di pagine
      ?>
      <li class="page-item">
         <a class="page-link" href="index.php?modulo=prodotti&pagina=<?php echo ($paginaSel-1); ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
         </a>
      </li>
      <?php
      }
      ?>
      <?php
      for($i=1;$i<=$totalePagine;$i++){ //permette la reinderizzazione alla pagina selezionata
      ?>
      <li class="page-item <?php echo ($paginaSel==$i)?" active ":" "; ?>">
            <a class="page-link" href="index.php?modulo=prodotti&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
      </li>
      <?php
      }
      ?>
      <?php
            if( $paginaSel!=$totalePagine ){ //se la pagina selezionata è la ultima pagina presente =) sarà possibile mostrare la sezione successiva nel navigatore di pagine
      ?>
      <li class="page-item">
         <a class="page-link" href="index.php?modulo=prodotti&pagina=<?php echo ($paginaSel+1); ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
         </a>
      </li>
      <?php
            }
      ?>
      </ul>
   </nav>
<?php
}
?>