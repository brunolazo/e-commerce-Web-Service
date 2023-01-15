<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../lib/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;

// Build our Editor instance and process the data coming from _POST
Editor::inst( $db, 'prodotti' )
	->fields(
		Field::inst( 'nome' )
			->validator( Validate::notEmpty( ValidateOptions::inst()
				->message( 'Necessario inserire un nome' )	
			) ),
		Field::inst( 'prezzo' )
			->validator( Validate::numeric() )
			->setFormatter( Format::ifEmpty(null) ),
		Field::inst( 'quantita' )
			->validator( Validate::numeric() )
			->setFormatter( Format::ifEmpty(null) ),
		Field::inst( 'descrizione' )
		->validator( Validate::notEmpty( ValidateOptions::inst()
			->message( 'Necessario inserire una descrizione' )	
		) )
	)
    ->join( //creazione di vincoli che permettono di collegare le tabelle prodotti, prodotti_files e files della base di dati
        Mjoin::inst( 'files' )
            ->link( 'prodotti.id', 'prodotti_files.prodotto_id' )
            ->link( 'files.id', 'prodotti_files.file_id' )
            ->fields(
                Field::inst( 'id' ) //viene chiamata l'istanza id di files[].id all'interno di Immagini in pannello.php
                    ->upload( Upload::inst( $_SERVER['DOCUMENT_ROOT'].'/ecommerce1/upload/__ID__.__EXTN__' ) 
                        ->db( 'files', 'id', array( //nella tabella files della base di dati verrà generato un id e verrà salvato il filename,filesize,webpath e systempath
                            'filename'    => Upload::DB_FILE_NAME,
                            'filesize'    => Upload::DB_FILE_SIZE,
                            'web_path'    => Upload::DB_WEB_PATH,
                            'system_path' => Upload::DB_SYSTEM_PATH
                        ) )
                        ->validator( Validate::fileSize( 5000000, 'Files must be smaller that 5M' ) )//la grandezza massima delle immagini sarà 5megabyte
                        ->validator( Validate::fileExtensions( array( 'webp','png', 'jpg', 'jpeg', 'gif' ), "Please upload an image" ) )
                    )
            )
    )
	->process( $_POST )
	->json();