<?php
    class aae_rdf_converter
    {
        private $base="<DefaultURL>";
        private $prefixes;
        private $ttlName;
        private $classTag;
        private $tableTag;
        private $pathToMappingClasses;
        private $mappingClasses;
        private $DIR;
        public function __construct($classT, $tableT, $cBase, $cTTLname="ttl/first_ttl.ttl", $mapClassPath="rdfClass"){
          $this->base='<'.$cBase.'>';
          $this->ttlName=$cTTLname;
          $this->classTag=$classT;
          $this->tableTag=$tableT;
          $this->pathToMappingClasses=$mapClassPath;
          $this->DIR=__DIR__;
        }
        public function createTestfile(){
          $testfile = fopen($this->DIR."/ttl/testfile.txt","w") or die ($this->DIR);
        }

        public function registerPrefixe($prefixArray){
          $this->prefixes=$prefixArray;       
        }

/**
* binds all classes in $classNameArray if they are located in $pathToMappingClasses
*/
        private function bindClasses($classNameArray){
          foreach($classNameArray as $cNameArr){
//Logger::getLogger('myLogger')->warn("require_once path: ".$this->DIR."|".$this->pathToMappingClasses."|".$cNameArr);
            require_once($this->DIR."/".$this->pathToMappingClasses."/".$cNameArr.".php");
          }
        }

/**
* collects all classnames in $pathToMappingClasses and initiates their binding
*/
        public function aquireMapping(){
//Logger::getLogger('myLogger')->warn("aquireMapping: ---------------------------------------------------------");
          $classTagLength= strlen($this->classTag)+1;   
          if ($handle = opendir($this->DIR."/".$this->pathToMappingClasses)) {
            $this->mappingClasses=array();
            while (false !== ($entry = readdir($handle))) {
              if((substr($entry, 0, $classTagLength)==($this->classTag."_"))){
                $this->mappingClasses[]=substr($entry,0,-4);
//Logger::getLogger('myLogger')->warn("mappingClasses: ".substr($entry,0,-4));
              }
            }
            $this->bindClasses($this->mappingClasses);
          }else{
//Logger::getLogger('myLogger')->warn("aquireMapping Failed: could not open ".$this->DIR."/".$this->pathToMappingClasses);
          }
        }
           
        public function generate_ttl(){
          $ttl= fopen($this->DIR."/".$this->ttlName,"w") or die ("Failed path in generate_ttl: ".$this->DIR.$this->ttlName);
          fwrite($ttl, "@base ".$this->base.".\n");
      //    fwrite($ttl,print_r($prefixes));
          foreach($this->prefixes as $pre){
            fwrite($ttl,"@prefix ".$pre[0].": <".$pre[2].$pre[1].">.\n");
          }

          foreach($this->mappingClasses as $mapC){
//Logger::getLogger('myLogger')->warn("MapC: ".$mapC."---------------------------------------------------------");
            $obj=(new ReflectionClass($mapC))->newInstance($this->classTag, $this->tableTag);
            $obj->loadMap();
            $arrObj=$obj->loadMore();
            foreach($arrObj as $arr){
              fwrite($ttl, $arr->toTurtle($this->prefixes)."\n");
            }
          }
          fclose($ttl); 
        }
    }
