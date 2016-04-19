<?php
    class aae_rdf_akteur extends AAE_RDF_LoadClass
    {
        public $AID='#id';
        public $name;
        public $email;
        public $telefon;
        public $url;
        public $ansprechpartner;
        public $funktion;
        public $bild;
        public $beschreibung;
        public $oeffnungszeiten;
        public $adresse='#n:1_adresse';
        public $ersteller;
        public $created;
        public $modified;
        public $event=array('#m:n','akteur_hat_event','event','AID','EID');
    }
