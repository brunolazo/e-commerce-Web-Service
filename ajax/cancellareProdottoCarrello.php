<?php
    $prodotti=unserialize($_COOKIE['prodotti']);
    foreach ($prodotti as $key => $value) {
        if($_REQUEST['id']==$value['id']){
            unset($prodotti[$key]); //rimuove l'elemento key del prodotto
        }
    }
    $prodotti=array_values($prodotti); //funzione che riceve un array e lo riistema per evitare che ci sia il campo vuoto
    setcookie("prodotti",serialize($prodotti));
    echo json_encode($prodotti);
?>