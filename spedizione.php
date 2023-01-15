<?php
if (isset($_SESSION['idCliente'])) { 
    if(isset($_REQUEST['salvare'])){ 
        
        $nomeCli= mysqli_real_escape_string($con,$_REQUEST['nomeCli']??'');
        $emailCli= mysqli_real_escape_string($con,$_REQUEST['emailCli']??'');
        $indirizzoCli= mysqli_real_escape_string($con,$_REQUEST['indirizzoCli']??'');
        $queryCli="UPDATE clienti set nome='$nomeCli',email='$emailCli',indirizzo='$indirizzoCli' where id='".$_SESSION['idCliente']."' "; 
        $resCli=mysqli_query($con,$queryCli); 
        
        $nomeSpe= mysqli_real_escape_string($con,$_REQUEST['nomeSpe']??'');
        $emailSpe= mysqli_real_escape_string($con,$_REQUEST['emailSpe']??'');
        $indirizzoSpe= mysqli_real_escape_string($con,$_REQUEST['indirizzoSpe']??'');
        
        $querySpe="INSERT INTO riceve (nome,email,indirizzo,idCli) VALUES ('$nomeSpe','$emailSpe','$indirizzoSpe','".$_SESSION['idCliente']."')
        ON DUPLICATE KEY UPDATE
        nome='$nomeSpe',email='$emailSpe',indirizzo='$indirizzoSpe'; ";
        $resSpe=mysqli_query($con,$querySpe);
        if($resCli && $resSpe){
            echo '<meta http-equiv="refresh" content="0; url=index.php?modulo=areapago" />'; 
        }
        else{
        ?>
            <div class="alert alert-danger" role="alert">
                Errore
            </div>
            <?php
        }
    }
    //querys che memorizzano nome,email,indirizzo della persona che effettua l'ordine e di quella che lo riceverà
    $queryCli="SELECT nome,email,indirizzo from clienti where id='".$_SESSION['idCliente']."';";
    $resCli=mysqli_query($con,$queryCli);
    $rowCli=mysqli_fetch_assoc($resCli);

    $querySpe="SELECT nome,email,indirizzo from riceve where idCli='".$_SESSION['idCliente']."';";
    $resSpe=mysqli_query($con,$querySpe);
    $rowSpe=mysqli_fetch_assoc($resSpe);
    //se all'interno della base dati il registro è vuoto =) inserisce uno spazio vuoto
    $rowSpe['nome']=$rowSpe['nome']??''; 
    $rowSpe['email']=$rowSpe['email']??''; 
    $rowSpe['indirizzo']=$rowSpe['indirizzo']??'';                
?>
    <form method="post">
        <div class="container mt-3">
            <div class="row">
                <div class="col-6">
                    <!-- form che conterrà nome, email ed indirizzo del cliente ; nel caso fossero già stati fatti degli ordini, questi dati già salvati saranno presi dal database -->
                    <h3>Dati cliente</h3>
                    <div class="form-group">
                        <label for="">Nome</label>
                        <input type="text" name="nomeCli" id="nomeCli" class="form-control" required="required" value="<?php echo $rowCli['nome'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="emailCli" id="emailCli" class="form-control" readonly="readonly" value="<?php echo $rowCli['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Indirizzo</label>
                        <textarea name="indirizzoCli" id="indirizzoCli" class="form-control" required="required" row="3"><?php echo $rowCli['indirizzo'] ?></textarea>
                    </div>
                </div>
                <div class="col-6">
                    <h3>Dati di spedizione</h3>
                    <div class="form-group">
                        <label for="">Nome</label>
                        <input type="text" name="nomeSpe" id="nomeSpe" class="form-control" required="required" value="<?php echo $rowSpe['nome'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="emailSpe" id="emailSpe" class="form-control" required="required" value="<?php echo $rowSpe['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Indirizzo</label>
                        <textarea name="indirizzoSpe" id="indirizzoSpe" class="form-control" required="required" row="3"><?php echo $rowSpe['indirizzo'] ?></textarea>
                    </div>
                    <!-- checkbox che permetterà di copiare i dati del cliente nel form dei dati per la spedizione -->
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="copiare" >
                            Copiare dati del cliente
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- pulsante per tornare al carrello e per procedere con il pagamento -->
        <a class="btn btn-warning" href="index.php?modulo=carrello" role="button">Tornare al carrello</a>
        <button type="submit" class="btn btn-primary float-right" name="salvare" value="salvare">Procedere con il pagamento</button>
    </form>
<?php
} else { //nel caso invece il cliente non abbia fatto il login
?>
    <div class="mt-5 text-center">
        è necessario fare il <a href="login.php">login</a> o la <a href="registro.php">registrazione</a>
    </div>
<?php
}
?>