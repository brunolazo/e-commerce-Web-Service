<form action="index.php?modulo=fattura" method="post" id="payment-form">

<table class="table table-striped table-inverse" id="tabellaAreaPago" >
    <thead class="thead-inverse">
        <tr>
            <th>Immagine</th>
            <th>Nome</th>
            <th>Quantita</th>
            <th>Prezzo</th>
            <th>Totale</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
    <div class="form-row">
        <h4 class="mt3">Dati della carta</h4>
        
        <div id="card-element" class="form-control">
            
        </div>
        
        <div id="card-errors" role="alert"></div>
    </div>
    <div class="mt-3">
        <h4>Termini e Condizioni</h4>
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Minima, soluta non quibusdam, assumenda mollitia expedita nihil quisquam sapiente optio rem reiciendis voluptatum laborum eos consectetur obcaecati sint incidunt doloribus placeat!
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" unchecked  required="required" >
                Accetto i Termini e Condizioni
            </label>
        </div>
    </div>
    <div class="mt-3">
        <a class="btn btn-warning" href="index.php?modulo=spedizione" role="button">Tornare alla spedizione</a>
        <button type="submit" class="btn btn-primary float-right">Pagare</button>
    </div>
</form>