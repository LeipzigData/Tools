<?php
    class AAE_RDF_LoadClass
    {
        public $classID;
        public $realArrVar;
        private $dbName;
        private $nToOne; 
        private $mToN;
       
        public function __construct($assocArray){
           $this->loadMap();
           if(isset($assocArray)){$this->manualLoad($assocArray);}
        }
     
        public function manualLoad($assocArray){
           foreach($this->realArrVar as $assocKey){ 
             $this->{$assocKey}=$assocArray[$assocKey];
           }
        }

        public function getClassAttr(){
           return  get_class_vars(get_class($this));
        }
        
        public function loadMap(){
           $this->nToOne=array();
           $this->mToN=array();
           $arrVar=$this->getClassAttr();
           $this->realArrVar=array();
           foreach($arrVar as $key => $value){
             if(substr($value,0,5)=='#n:1_'){ $this->nToOne[]=array($key ,substr($value,5)); }
             if(is_array($value)){ if($value[0]=='#m:n'){ $this->mToN[]=array($key, $value[1], $value[2], $value[3], $value[4]);}}
             if($value=='#id'){$this->classID=$key;}
             if(($key!='classID')&&($key!='realArrVar')&&($key!='dbName')&&($key!='nToOne')&&($key!='mToN')&&($key!=end($this->mToN)[0])) {$this->realArrVar[]=$key;}
           }
           $this->dbName=get_class($this);
           $this->dbName=substr($this->dbName,7);
           $this->dbName='aae_data'.$this->dbName;
           return;
        }
    
        public function selfLoad($ID, $bool=true){ //$bool prevents loading cycle
           $query=null;
           $query=db_select($this->dbName,'x')
             ->fields('x',$this->realArrVar)
             ->condition($this->classID, $ID,'=')
             ->range(0,1)
             ->execute();         
           foreach($query as $que){
             foreach($this->realArrVar as $fields){
               $this->{$fields}=$que->{$fields};
             }
             if($bool){
               foreach($this->nToOne as $fk){ //
                 $fkN=$this->{$fk[0]};               
                 if($fkN!='NUll'){
                   $this->{$fk[0]}=(new ReflectionClass('aae_rdf_'.$fk[1]))->newInstance();
                   $this->{$fk[0]}->loadMap();
                   $this->{$fk[0]}->selfLoad($fkN,false);
                 }
               }

               foreach($this->mToN as $fk){
                 $readObj=(new ReflectionClass('aae_rdf_'.$fk[2]))->newInstance();
                 $readObj->loadMap();
                 $joinQuery=db_select('aae_data_'.$fk[1],'x')
                   ->fields('x',array($fk[3],$fk [4]))
                   ->condition('x.'.$fk[3],$ID,'=');
                 $joinQuery->join('aae_data_'.$fk[2], 'y', 'x.'.$fk[4].'= y.'.$readObj->classID);
                 $joinQuery->fields('y',$readObj->realArrVar);
                 $joinResult=$joinQuery->execute();
                 $this->{$fk[0]}=array();
                 while($record= $joinResult->fetchAssoc() ){
                   $properties=array();
                   foreach($readObj->realArrVar as $prop){
                     $properties[$prop]=$record[$prop];
                   }
       //            echo "<script>console.log('".json_encode($properties)."');</script>";
                   $this->{$fk[0]}[] = (new ReflectionClass('aae_rdf_'.$fk[2]))->newInstance($properties);                
                 }
               }      
             }      
           }
           return $this;
        }
  
        public function loadMore(){
          $mapClass=get_class($this);
          $IDs=array();
          $query=db_select($this->dbName,'x')
            ->fields('x',$this->realArrVar)
            ->execute();
          $resultArr=array();
          foreach($query as $que)
          {
            $obj= (new ReflectionClass($mapClass))->newInstance();
            foreach($this->realArrVar as $fields){
              $obj->{$fields}=$que->{$fields};
              if($fields==$this->classID){$IDs[]=$que->{$fields};}
            }
            foreach($this->nToOne as $fk){ //
               $fkN=$obj->{$fk[0]};
               if($fkN!='NUll'){
                 $obj->{$fk[0]}=(new ReflectionClass('aae_rdf_'.$fk[1]))->newInstance();
                 $obj->{$fk[0]}->loadMap();
                 $obj->{$fk[0]}->selfLoad($fkN,false);
               }
             }

            $resultArr[]=$obj;
          }
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          foreach($this->mToN as $fk){
              $readObj=(new ReflectionClass('aae_rdf_'.$fk[2]))->newInstance();
              $readObj->loadMap();
              $joinQuery=db_select('aae_data_'.$fk[1],'x')
                ->fields('x',array($fk[3],$fk [4]))
                ->condition('x.'.$fk[3],$IDs,'IN');
              $joinQuery->join('aae_data_'.$fk[2], 'y', 'x.'.$fk[4].'= y.'.$readObj->classID);
              $joinQuery->fields('y',$readObj->realArrVar);
              $joinResult=$joinQuery->execute();
              foreach($resultArr as $res){
                $res->{$fk[0]}=array();
              }

              while($record= $joinResult->fetchAssoc() ){
                $properties=array();
                foreach($readObj->realArrVar as $prop){
                  $properties[$prop]=$record[$prop];
                }
                foreach($resultArr as $res){
                  if($res->{$this->classID}==$record[$this->classID]){
                    $res->{$fk[0]}[] = (new ReflectionClass('aae_rdf_'.$fk[2]))->newInstance($properties);
                  }
                }
          //      echo "<script>console.log('".json_encode($properties)."');</script>";
          //      $this->{$fk[0]}[] = (new ReflectionClass('aae_rdf_'.$fk[2]))->newInstance($properties);
              }
          }
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

          return $resultArr;
        }
        
        public function getRelTurtleID(){
          $className=get_class($this);          
          return "<#".$className.$this->{$this->classID}.">";
          
        }

        public function toTurtle($prefixes){
          $className=get_class($this);
          $pre='default';
          foreach($prefixes as $pref){
            if($pref[1]==$className){ $pre=$pref[0];}
          }
     //     echo "<script>console.log('ci".$this->classID."');</script>";
          $result="<#".$className.$this->{$this->classID}.">\n";
          $unused=true;
          foreach($this->realArrVar as $attr){
            $unused=false;
            if(is_object($this->{$attr})){$result.="    ".$pre.':'.$attr." ".$this->{$attr}->getRelTurtleID().";\n";} //n:1 Regelung
            else
            {$result.="    ".$pre.':'.$attr.' """'.$this->{$attr}."\"\"\";\n";}
          }
          
          foreach($this->mToN as $m2n){
            if(is_array($this->{$m2n[0]})){
            $unused=false;
            foreach($this->{$m2n[0]} as $m2nObject){
              $result.="    ".$pre.':'.$m2n[0]." \"".$m2nObject->getRelTurtleID()."\";\n";
            }
            }
          }
          if($unused){$result=substr($result,0,-1).".\n";}else{$result=substr($result,0,-2).".\n";}
          return $result;
        } 
    }
