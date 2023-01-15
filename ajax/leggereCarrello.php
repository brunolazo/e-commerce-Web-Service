<?php
    $prodotti= unserialize($_COOKIE['prodotti']??''); //lista di prodotti ottenuta dalla cookie prodotto
    echo json_encode($prodotti); //stampare su json
?>