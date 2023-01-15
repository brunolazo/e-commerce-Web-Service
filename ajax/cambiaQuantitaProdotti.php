<?php
    $prodotti=unserialize($_COOKIE['prodotti']);
    foreach ($prodotti as $key => $value) {
        if($_REQUEST['id']==$value['id']){ //se l'id ricevuto tramite ajax è uguale al valore dell'id nel value, cioè quelo trasmesso =)
            if(($_REQUEST['tipo']=="piu")&&(($prodotti[$key]['quantita'])<($prodotti[$key]['quantitaPresente']))) //se il pulsante è di tipo piu e la quantità che si vuole aggiungere e inferiore alla quantità disponibile del prodotto=) la quantita verrà incrementata 
            {   
                 $prodotti[$key]['quantita']++;
            }
            if(($_REQUEST['tipo']=="meno")&&($prodotti[$key]['quantita']>1)) //se il pulsante è di tipo meno e la quantità che si vuole aggiungere è un valore positivo=) la quantita verrà decrementata
            {
                $prodotti[$key]['quantita']--;
            }
        }
    }
    setcookie("prodotti",serialize($prodotti)); //memorizzarlo nella cookie i prodotti
    echo json_encode($prodotti);
?>