$(document).ready(function () {
    $.ajax({
        type: "post", 
        url: "ajax/leggereCarrello.php",
        dataType: "json", 
        success: function (response) {
            riempiCarrello(response);
        }
    });
    $.ajax({
        type: "post",
        url: "ajax/leggereCarrello.php",
        dataType: "json",
        success: function (response) {           
            riempireTabellaCarrello(response);
        }
     });
     function riempireTabellaCarrello(response){ 
        $("#tabellaCarrello tbody").text("");
        var TOTALE=0;
        response.forEach(element => { 
            var prezzo=parseFloat(element['prezzo']); 
            var totaleProd=element['quantita']*prezzo; 
            TOTALE=TOTALE+totaleProd; 
            $("#tabellaCarrello tbody").append( 
                `
                <tr>
                    <td><img src="${element['web_path']}" class="img-size-50"/></td>
                    <td>${element['nome']}</td>
                    <td>
                        ${element['quantita']}
                        <button type="button" class="btn-xs btn-primary piu" 
                        data-id="${element['id']}"
                        data-tipo="piu"
                        >+</button>
                        <button type="button" class="btn-xs btn-danger meno" 
                        data-id="${element['id']}"
                        data-tipo="meno"
                        >-</button>
                    </td>
                    <td>€${prezzo.toFixed(2)}</td>
                    <td>€${totaleProd.toFixed(2)}</td>
                    <td><i class="fa fa-trash text-danger cancellareProdotto" data-id="${element['id']}" ></i></td>
                <tr>
                `
                
            );
        });
        $("#tabellaCarrello tbody").append( 
            `
            <tr>
                <td colspan="4" class="text-right"><strong>Totale:</strong></td>
                <td>€${TOTALE.toFixed(2)}</td>
                <td></td>
            <tr>
            `
        );
        if(TOTALE!=0) 
        {
            $("#tabellaCarrello tbody").append( 
                `
                <a class="btn btn-warning" href="index.php?modulo=prodotti" role="button">Tornare a prodotti</a>
                <a class="btn btn-primary float-right" href="index.php?modulo=spedizione" role="button">Procedere con la spedizione</a>        
                `
            );
        }
        else 
        {
            $("#tabellaCarrello tbody").append( 
                `             
                <a class="btn btn-warning" href="index.php?modulo=prodotti" role="button">Tornare a prodotti</a>   
                `
            );
        }
    }
    $.ajax({
        type: "post",
        url: "ajax/leggereCarrello.php",
        dataType: "json",
        success: function (response) {
            riempireTabellaAreaPago(response);
        }
    });
    function riempireTabellaAreaPago(response){ 
        $("#tabellaAreaPago tbody").text("");
        var TOTALE=0;
        response.forEach(element => { 
            var prezzo=parseFloat(element['prezzo']); 
            var totaleProd=element['quantita']*prezzo; 
            TOTALE=TOTALE+totaleProd; 
            $("#tabellaAreaPago tbody").append( 
                `
                <tr>
                    <td><img src="${element['web_path']}" class="img-size-50"/></td>
                    <td>${element['nome']}</td>
                    <td>
                        ${element['quantita']}
                        <input type="hidden" name="id[]" value="${element['id']}">
                        <input type="hidden" name="quantita[]" value="${element['quantita']}">
                        <input type="hidden" name="prezzo[]" value="${prezzo.toFixed(2)}">
                    </td>
                    <td>€${prezzo.toFixed(2)}</td>
                    <td>€${totaleProd.toFixed(2)}</td>
                <tr>
                `
                
            );
        });
        $("#tabellaAreaPago tbody").append( 
            `
            <tr>
                <td colspan="4" class="text-right"><strong>Totale:</strong></td>
                <td>
                €${TOTALE.toFixed(2)}
                <input type="hidden" name="totale" value="${TOTALE.toFixed(2)*100}" >
                </td>
            <tr>
            `
        );
    }
    $(document).on("click",".piu,.meno",function(e){ 
        e.preventDefault();
        
        var id=$(this).data('id'); 
        var tipo=$(this).data('tipo');
        $.ajax({
            type: "post",
            url: "ajax/cambiaQuantitaProdotti.php",
            data: {"id":id,"tipo":tipo}, 
            dataType: "json",
            success: function (response) {
                riempireTabellaCarrello(response);
                riempiCarrello(response);
            }
        });
    });
    $(document).on("click",".cancellareProdotto",function(e){ 
        e.preventDefault();
        var id=$(this).data('id');
        $.ajax({
            type: "post",
            url: "ajax/cancellareProdottoCarrello.php",
            data: {"id":id},
            dataType: "json",
            success: function (response) {
                riempireTabellaCarrello(response);
                riempiCarrello(response);
            }
        });
    });
    
    $("#aggiungereCarrello").click(function (e) { 
        e.preventDefault();
        var id=$(this).data('id');
        var nome=$(this).data('nome');
        var web_path=$(this).data('web_path');
        var quantita=$("#quantitaProdotto").val();
        var prezzo=$(this).data('prezzo');
        var quantitaPresente=$(this).data('quantita');
        if((quantita<=quantitaPresente)&&(quantita>0)) 
        {
            
            $.ajax({
                type: "post", 
                url: "ajax/aggiungereCarrello.php",
                data: {"id":id,"nome":nome,"web_path":web_path,"quantita":quantita,"prezzo":prezzo,"quantitaPresente":quantitaPresente}, 
                dataType: "json", 
                success: function (response) {               
                    riempiCarrello(response);
                    $("#badgeProdotto").hide(500).show(500).hide(500).show(500).hide(500).show(500); 
                    $("#iconaCarrello").click();
                }            
            });
        }
    });
    function riempiCarrello(response){
        var quantita=Object.keys(response).length; 
        if(quantita>0){
            $("#badgeProdotto").text(quantita);
        }else{
            $("#badgeProdotto").text("");
        }
        $("#listaCarrello").text("");
        response.forEach(element => {
            $("#listaCarrello").append( 
                
                `
                <a href="index.php?modulo=dettagliprodotto&id=${element['id']}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="${element['web_path']}" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                ${element['nome']}
                                <span class="float-right text-sm text-primary"><i class="fas fa-eye"></i></span>
                            </h3>
                            <p class="text-sm">Quantita ${element['quantita']}</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                `
            );           
        });
        if(quantita>0){
            $("#listaCarrello").append( 
                `
                <a href="index.php?modulo=carrello" class="dropdown-item dropdown-footer text-primary">
                    Vedere carrello 
                    <i class="fa fa-cart-plus"></i>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer text-danger" id="cancellareCarrello">
                    Cancellare carrello
                    <i class="fa fa-trash"></i>
                </a>
                `
            );
        }        
    }
    $(document).on("click","#cancellareCarrello",function(e){ 
        e.preventDefault();        
        $.ajax({           
            type: "post",
            url: "ajax/cancellareCarrello.php",
            dataType: "json", 
            success: function (response) { 
                riempiCarrello(response); 
            }
       });
   });   
    
    var nomeSpe=$("#nomeSpe").val();
    var emailSpe=$("#emailSpe").val();
    var indirizzoSpe=$("#indirizzoSpe").val();
    $("#copiare").click(function (e) { 
       var nomeCli=$("#nomeCli").val();
       var emailCli=$("#emailCli").val();
       var indirizzoCli=$("#indirizzoCli").val(); 
       if( $(this).prop("checked")==true ){ 
          $("#nomeSpe").val(nomeCli);
          $("#emailSpe").val(emailCli);
          $("#indirizzoSpe").val(indirizzoCli);
       }else{ 
          $("#nomeSpe").val(nomeSpe);
          $("#emailSpe").val(emailSpe);
          $("#indirizzoSpe").val(indirizzoSpe);
       }       
    });
 });