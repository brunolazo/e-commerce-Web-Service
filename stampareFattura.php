<?php
    session_start();
    include_once "admin/dbecommerce.php";//mi connetto alla base di dati
    $con = mysqli_connect($host, $user, $pass, $db);//inizializzo la connessione
    //query che restituisce nome,email,indirizzo della persona che riceverà l'ordine
    $queryRiceve="SELECT nome,email,indirizzo 
    from riceve 
    where idCli='".$_SESSION['idCliente']."';"; 
    $resRiceve=mysqli_query($con,$queryRiceve);//ottengo il risultato della query
    $rowRiceve=mysqli_fetch_assoc($resRiceve);//registro nel quale verrà memorizzato il risultato del query
    //query che restituisce nome,email,indirizzo della persona che ha effettuato l'ordine
    $queryCli="SELECT nome,email,indirizzo 
    from clienti 
    where id='".$_SESSION['idCliente']."';";
    $resCli=mysqli_query($con,$queryCli);
    $rowCli=mysqli_fetch_assoc($resCli);
    $id_vendita= mysqli_real_escape_string($con,$_REQUEST['id_vendita']??'');
    $queryVendita="SELECT v.id,v.data
    FROM vendite AS v
    WHERE v.id = '$id_vendita';";
    $resVendita=mysqli_query($con,$queryVendita);
    $rowVendita=mysqli_fetch_assoc($resVendita);
?>
<?php ob_start(); ?> 
    <div><font size="6">
        Bruno's Watch Collection
    </div>
    <table style="width: 750px;margin-top: 20px;">
        <thead>
            <tr class="text-left"  style="text-align: left;">
                <th>Indirizzo di fatturazione</th>
                <th>Indirizzo di spedizione</th>
                <th>Dati della fattura</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Nome: </strong><?php echo $rowCli['nome'] ?><br>
                    <strong>Email: </strong><?php echo $rowCli['email'] ?><br>
                    <strong>Indirizzo: </strong><?php echo $rowCli['indirizzo'] ?><br>
                </td>
                <td>
                    <strong>Nome: </strong><?php echo $rowRiceve['nome'] ?><br>
                    <strong>Email: </strong><?php echo $rowRiceve['email'] ?><br>
                    <strong>Indirizzo: </strong><?php echo $rowRiceve['indirizzo'] ?><br>
                </td>
                <td>
                    <strong>Id: </strong><?php echo $rowVendita['id'] ?><br>
                    <strong>Email: </strong><?php echo $rowVendita['data'] ?><br>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 750px;margin-top: 30px;">
        <thead>
            <tr class="text-left"  style="text-align: left;">
                <th>Nome</th>
                <th>Quantità</th>
                <th>Prezzo</th>
                <th>Totale</th>
            </tr>
        </thead>
        <tbody>
            <?php
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
                <td colspan="3" class="text-right"  style="text-align: right;">Totale: </td>
                <td><?php echo "€".number_format($totale, 2); ?></td>
            </tr>
        </tbody>
    </table>
<?php 
$html= ob_get_clean(); ?> 
<?php
    require('phpToPDF.php');
    $pdf_options = array(
        "source_type" => 'html',
        "source" => $html,
        "action" => 'view'
    );
    phptopdf($pdf_options);
?>