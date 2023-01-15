<?php
    $prodotti= unserialize($_COOKIE['prodotti']??''); //lista di prodotti ottenuta dalla cookie prodotto
    if(is_array($prodotti)==false)$prodotti=array(); //se i prodotti non  sono un array =) li converte in un array
    $seProdottoPresente=false; //booleano che indica la presenza del prodotto
    foreach ($prodotti as $key => $value) { //ciclo dei prodotti
         //controllare che il prodotto che si sta cercando di inserire nella cookie non sia già presente all'interno di essa
        if($value['id']==$_REQUEST['id']){ //confronto ogni id dei prodotti e li confronto con quelli ricevuti dal prodotto tramite ajax
            if(($prodotti[$key]['quantita']+$_REQUEST['quantita'])<=($prodotti[$key]['quantitaPresente'])) //se la quantità che si cerca di aggiungere al prodotto nel carrello è inferiore o uguale alla quantità disponibile di tale prodotto =)
            {
                $prodotti[$key]['quantita']=$prodotti[$key]['quantita']+$_REQUEST['quantita']; //la quantità di quel prodotto verrà sommata a quella inviata tramite ajax 
            }
            $seProdottoPresente=true;
        }
    }
    if($seProdottoPresente==false){//se prodotto non è ancora presente
        $nuovo=array( //creazione di array che conterrà i valori che vengono ricevuti tramite ajax
            "id"=>$_REQUEST['id'],
            "nome"=>$_REQUEST['nome'],
            "web_path"=>$_REQUEST['web_path'],
            "quantita"=>$_REQUEST['quantita'],
            "prezzo"=>$_REQUEST['prezzo'],
            "quantitaPresente"=>$_REQUEST['quantitaPresente']
        );
        array_push($prodotti,$nuovo);//all'interno dell'array $prodotti aggiungerò $nuovo
    }
    setcookie("prodotti",serialize($prodotti)); //nelle cookie verranno memorizzato i prodotti
    echo json_encode($prodotti); //stampare su json
?>