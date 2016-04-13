<?php
    class aae_rdf_converter
    {
        private $base="<TestURL>";
        private $prefixes;
        private $ttlName;
        public function __construct($cBase, $cTTLname="first_ttl.ttl"){
          $this->base='<'.$cBase.'>';
          $this->ttlName=$cTTLname;
        }
        public function createTestfile(){
          $testfile = fopen(__DIR__."/ttl/testfile.txt","w") or die (__DIR__);
        }
 
        public function registerPrefixe($prefixArray){
          $this->prefixes=$prefixArray;       
        }
       
        public function generate_ttl(){
          $ttl= fopen(__DIR__."/ttl/".$this->ttlName,"w") or die (__DIR__);
          fwrite($ttl, "@base ".$this->base.".\n");
      //    fwrite($ttl,print_r($prefixes));
          foreach($this->prefixes as $pre){
            fwrite($ttl,"@prefix ".$pre[0].": <".$pre[2].$pre[1].">.\n");
          }
          $obj=new aae_rdf_akteur();
          $obj->loadMap();
          $arrObj=$obj->loadMore();
          foreach($arrObj as $arr){
            fwrite($ttl, $arr->toTurtle($this->prefixes)."\n");
          }

          $obj=new aae_rdf_adresse();
          $obj->loadMap();
          $arrObj=$obj->loadMore();
          foreach($arrObj as $arr){
            fwrite($ttl, $arr->toTurtle($this->prefixes)."\n");
          }
          $obj=new aae_rdf_event();
          $obj->loadMap();
          $arrObj=$obj->loadMore();
          foreach($arrObj as $arr){
            fwrite($ttl, $arr->toTurtle($this->prefixes)."\n");
          }
          $obj=new aae_rdf_sparte();
          $obj->loadMap();
          $arrObj=$obj->loadMore();
          foreach($arrObj as $arr){
            fwrite($ttl, $arr->toTurtle($this->prefixes)."\n");
          }
          $obj=new aae_rdf_bezirke();
          $obj->loadMap();
          $arrObj=$obj->loadMore();
          foreach($arrObj as $arr){
            fwrite($ttl, $arr->toTurtle($this->prefixes)."\n");
          }

          fclose($ttl); 
        }
    }
