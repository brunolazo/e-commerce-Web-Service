<?php
    $totale=$_REQUEST['totale']??'';
    include_once "stripe/init.php";
    \Stripe\Stripe::setApiKey("sk_test_51Jlhc0Gft7X22mNgKWt6vD8DXxkI6jtdIEzfbAtHn137B9YpbrvhV3dcb6FlsUt7YjjQYW9gNvEuhlCDd8AgB9D700l4kW8B6o");
    $token=$_POST['stripeToken'];
    $charge=\Stripe\Charge::create([
        'amount'=>$totale,
        'currency'=>'eur',
        'description'=>'Pagamento ecommerce',
        'source'=>$token
    ]);
    if($charge['captured']){ 
         
         $queryVendita="INSERT INTO vendite 
         (id_cliente,idPagamento,data) values
         ('".$_SESSION['idCliente']."','".$charge['id']."',now());
         "; 
         $resVendita=mysqli_query($con,$queryVendita); 
         $id=mysqli_insert_id($con); 
        $inserimentoDettagli="";
        $quantitaProd=count($_REQUEST['id']); 
        for($i=0;$i<$quantitaProd;$i++){ 
            $totale=$_REQUEST['prezzo'][$i]*$_REQUEST['quantita'][$i]; 
            
            $inserimentoDettagli=$inserimentoDettagli."('".$_REQUEST['id'][$i]."','$id','".$_REQUEST['quantita'][$i]."','".$_REQUEST['prezzo'][$i]."','$totale'),";
        }
        $inserimentoDettagli=rtrim($inserimentoDettagli,","); 
        
        $queryDettagli="INSERT INTO dettagli_vendite (id_prodotto, id_vendita, quantita, prezzo, totale) values 
        $inserimentoDettagli;";
        $resDettagli=mysqli_query($con,$queryDettagli); 
        if($resDettagli && $resVendita){ //se l'inserimento della tabella "vendite" e "dettagli_vendite" è avvenuto con successo =)
            ?>
            <div class="row">
                <div class="col-6">
                    <?php mostrareFattura($id); ?><!-- funzione che mostrerà i dati della persona che riceverà l'ordine -->
                </div>
                <div class="col-6">
                    <?php mostrareDettagli($id); ?><!-- funzione che mostrerà i dettagli dell'ordine effettuato -->
                </div>
            </div>
            <?php
            cancellareCarrello();
        }
        //query che aggiornerà la quantità di prodotti sottraendo quelli che sono acquistati nell'ultimo ordine
        $queryAggiorna="UPDATE prodotti p INNER JOIN dettagli_vendite dv ON p.id=dv.id_prodotto 
        SET p.quantita=p.quantita-dv.quantita
        where dv.id_vendita='".$id."';
        ";
        $resAggiorna=mysqli_query($con,$queryAggiorna); //risultato della query
    }

    function mostrareFattura($id_vendita){
    ?>
    <table class="table">
        <thead>
            <tr>
                <th colspan="3" class="text-center">Persona che riceve</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Indirizzo</th>
            </tr>
        </thead>
        <tbody>
            <?php
                global $con; //ottengo la variabile $con tramite global, trovandosi fuori dalla funzione
                //query che restituisce nome,email,indirizzo della persona che riceverà l'ordine
                $queryRiceve="SELECT nome,email,indirizzo 
                from riceve 
                where idCli='".$_SESSION['idCliente']."';"; 
                $resRiceve=mysqli_query($con,$queryRiceve);//ottengo il risultato della query
                $row=mysqli_fetch_assoc($resRiceve);//registro nel quale verrà memorizzato il risultato del query
            ?>
            <tr>
                <td><?php echo $row['nome'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['indirizzo'] ?></td>
            </tr>
        </tbody>
    </table>
    <?php
    }
    function mostrareDettagli($id_vendita){
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th colspan="3" class="text-center">Dettagli della vendita</th>
                </tr>
                <tr>
                    <th>Nome</th>
                    <th>Quantità</th>
                    <th>Prezzo</th>
                    <th>Totale</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    global $con;
                    //query che restituirà i dettagli dei prodotti nell'ordine effettuato
                    $queryDettagli="SELECT
                    p.nome,
                    dv.quantita,
                    dv.prezzo,
                    dv.totale
                    FROM
                    vendite AS v
                    INNER JOIN dettagli_vendite AS dv ON dv.id_vendita = v.id
                    INNER JOIN prodotti AS p ON p.id = dv.id_prodotto
                    WHERE
                    v.id = '$id_vendita'";
                    $resDettagli=mysqli_query($con,$queryDettagli);
                    $totale=0;
                    while($row=mysqli_fetch_assoc($resDettagli)){
                        $totale=$totale+$row['totale']; //variabile che conterrà il prezzo totale
                ?>
                <tr>
                    
                    <td><?php echo $row['nome'] ?></td>
                    <td><?php echo $row['quantita'] ?></td>
                    <td><?php echo "€".number_format($row['prezzo'], 2); ?></td>
                    <td><?php echo "€".number_format($row['totale'], 2); ?></td>
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td colspan="3" class="text-right">Totale:</td>
                    <td><?php echo "€".number_format($totale, 2); ?></td>
                </tr>

            </tbody>
        </table>
        <!-- pulsante per la creazione della fattura in pdf -->
        <a class="btn btn-secondary float-right" target="_blank" href="stampareFattura.php?id_vendita=<?php echo $id_vendita; ?>" role="button">Stampare fattura <i class="fas fa-file-pdf"></i> </a>
        <?php
        }

?>