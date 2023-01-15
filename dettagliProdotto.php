<?php
   $id = mysqli_real_escape_string($con, $_REQUEST['id'] ?? ''); 
   $queryProdotto = "SELECT id,nome,prezzo,quantita,descrizione FROM prodotti where id='$id';  ";
   $resProdotto = mysqli_query($con, $queryProdotto); 
   $rowProdotto = mysqli_fetch_assoc($resProdotto); 
?>

<div class="card card-solid">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6">
            <h3 class="d-inline-block d-sm-none"><?php echo $rowProdotto['nome'] ?></h3>   
                <?php    
                $queryImmagini = "SELECT  
                f.web_path
                FROM
                prodotti AS p
                INNER JOIN prodotti_files AS pf ON pf.prodotto_id=p.id
                INNER JOIN files AS f ON f.id=pf.file_id
                WHERE p.id='$id';
                ";
                $resPrimaImmagine = mysqli_query($con, $queryImmagini); 
                $rowPrimaImmagine=mysqli_fetch_assoc($resPrimaImmagine); 
                ?>
                <div class="col-12">
                  <img src="<?php echo $rowPrimaImmagine['web_path']; ?>" class="product-image" id="PrimaImmagine">  
                </div>
                <div class="col-12 product-image-thumbs">
                    <?php
                    $resImmagini = mysqli_query($con, $queryImmagini);
                    while ($rowImmagini = mysqli_fetch_assoc($resImmagini)) {
                    ?>
                        <div class="product-image-thumb"><img src="<?php echo $rowImmagini['web_path']; ?>" onclick="cambiaImmagine(this)"></div>   
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 col-sm-6">
            <h3 class="my-3"><?php echo $rowProdotto['nome'] ?></h3> 
                <p><?php echo $rowProdotto['descrizione'] ?></p>
                <hr>
                <h4>Quantità: <?php echo $rowProdotto['quantita'] ?></h4>
                <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">  
                    <?php 
                        $prezzo=$rowProdotto['prezzo'];
                        $prezzoStringa=number_format($prezzo, 2);
                        echo "€$prezzoStringa";
                     ?>
                    </h2>
                </div>
                <div class="mt-4">
                    <!-- pulsante per aggiungere prodotto al carrello -->
                    <!-- il pulsante aggiungereCarrello memorizzerà l'id, nome, percorso dell'immagine, prezzo del prodotto e quantità disponibile del prodotto --> 
                    <button class="btn btn-primary btn-lg btn-flat" id="aggiungereCarrello"
                    data-id="<?php echo $_REQUEST['id'] ?>"
                    data-nome="<?php echo $rowProdotto['nome'] ?>"
                    data-web_path="<?php echo $rowPrimaImmagine['web_path'] ?>"
                    data-prezzo="<?php echo $rowProdotto['prezzo'] ?>"
                    data-quantita="<?php echo $rowProdotto['quantita'] ?>"
                    >
                        <i class="fas fa-cart-plus fa-lg mr-2"></i>
                        Aggiungere al Carrello
                    </button>
                </div>
                <div class="mt-4">
                    Quantità
                    <!-- il valore minimo del prodotto che è possibile aggiungere al carrello è 1, il valore massimo del prodotto che è possibile aggiungere al carrello è uguale alla quantità massima disponibile del prodotto -->
                    <input type="number" class="form-control" id="quantitaProdotto" value="1" min="1" max="<?php echo $rowProdotto['quantita'] ?>">
                </div>
            </div>
        </div> 
    </div>
    <!-- /.card-body -->
</div>
<!-- script per cambiare immagine tra quelle presenti -->
<script>
   function cambiaImmagine(x){
    document.getElementById('PrimaImmagine').src= x.src;
   }
</script>
<!-- /.card -->