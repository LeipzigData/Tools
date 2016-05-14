<?php
    class AAE_RDF_LoadClass
    {
        public $classID;
        public $realArrVar;
        private $dbName;
        private $nToOne; 
        private $mToN;
        private $classTag;
        private $tableTag;
        private $classTagSize;
        private $tableTagSize;
       
        public function __construct($classT,$tableT,$assocArray){
           $this->classTag=$classT;
           $this->tableTag=$tableT;
           $this->classTagSize=strlen($classT);
           $this->tableTagSize=strlen($tableT);
           $this->loadMap();
           //Logger::getLogger('myLogger')->warn("construct: ".$classT." ".$tableT." ".$this->classTagSize." ".$this->tableTagSize);                           //logging
           if(isset($assocArray)){$this->manualLoad($assocArray);}
        }
/**
* part of the constructor
* assigns values to regular (from the child class) attributes
*/ 
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
             if(($key!='classID')&&($key!='realArrVar')&&($key!='dbName')&&($key!='nToOne')&&($key!='mToN')&&($key!=end($this->mToN)[0])&&($key!='classTag')&&($key!='tableTag')&&($key!='classTagSize')&&($key!='tableTagSize')) {$this->realArrVar[]=$key;}
           }
           //Logger::getLogger('myLogger')->warn("dbName1: ".$this->dbName);
           $this->dbName=get_class($this);
           //Logger::getLogger('myLogger')->warn("dbName2: ".$this->dbName);
           $this->dbName=substr($this->dbName,$this->classTagSize);
           //Logger::getLogger('myLogger')->warn("dbName3: ".$this->dbName." classTagSize: ".$this->classTagSize);
           $this->dbName=$this->tableTag.$this->dbName;
           //Logger::getLogger('myLogger')->warn("dbName4: ".$this->dbName);
           return;
        }
    
        public function selfLoad($ID, $bool=true){ //$bool prevents loading cycle
           $query=null;
           $db=dbManager::getConnection();
           $SQLstr="SELECT ".implode(",",$this->realArrVar)." FROM ".$this->dbName." WHERE ".$this->classID." = ?";
           $bindVariables=array($ID);
           $query=$db->execute($SQLstr, $bindVariables);
          
           foreach($query as $que){
             foreach($this->realArrVar as $fields){

               $this->{$fields}=$que[$fields];
             }
             if($bool){
               foreach($this->nToOne as $fk){
                 $fkN=$this->{$fk[0]};               
                 if($fkN!='NUll'){
                   $this->{$fk[0]}=(new ReflectionClass($this->classTag.'_'.$fk[1]))->newInstance($this->classTag, $this->tableTag);
                   $this->{$fk[0]}->loadMap();
                   $this->{$fk[0]}->selfLoad($fkN,false);
                 }
               }
               foreach($this->mToN as $fk){
                 $readObj=(new ReflectionClass($this->classTag.'_'.$fk[2]))->newInstance($this->classTag, $this->tableTag);
                 $readObj->loadMap();
                 $joinQuery=db_select($this->tableTag.'_'.$fk[1],'x')
                   ->fields('x',array($fk[3],$fk [4]))
                   ->condition('x.'.$fk[3],$ID,'=');
                 $joinQuery->join($this->tableTag.'_'.$fk[2], 'y', 'x.'.$fk[4].'= y.'.$readObj->classID);
                 $joinQuery->fields('y',$readObj->realArrVar);
                 
                 $joinQuery="SELECT y.* FROM ".$this->tableTag."_".$fk[1]." x JOIN ".$this->tableTag."_".$fk[2]." y ON x.".$fk[4]."= y.".$readObj->classID." WHERE x.".$fk[3]."=".$ID;
                 $joinResult=$db->execute($joinQuery);
                 $this->{$fk[0]}=array();
                 foreach($joinResult as $record){
                   $properties=array();
                   foreach($readObj->realArrVar as $prop){
                     $properties[$prop]=$record[$prop];
                   }
                   $this->{$fk[0]}[] = (new ReflectionClass($this->classTag.'_'.$fk[2]))->newInstance($this->classTag, $this->tableTag, $properties);                
                 }
               }      
             }      
           }
           return $this;
        }
  
        public function loadMore(){
          $db=dbManager::getConnection();
          $mapClass=get_class($this);
          $IDs=array();
          $SQLstr="SELECT x.".implode(",",$this->realArrVar)." FROM ".$this->dbName." x";
          $query=$db->execute($SQLstr);
          $resultArr=array();
          foreach($query as $que)
          {
            $obj= (new ReflectionClass($mapClass))->newInstance($this->classTag, $this->tableTag);
            foreach($this->realArrVar as $fields){
              $obj->{$fields}=$que[$fields];
              if($fields==$this->classID){$IDs[]=$que[$fields];}
            }
            foreach($this->nToOne as $fk){ //
               $fkN=$obj->{$fk[0]};
               if($fkN!='NUll'){
                 $obj->{$fk[0]}=(new ReflectionClass($this->classTag.'_'.$fk[1]))->newInstance($this->classTag, $this->tableTag);
                 $obj->{$fk[0]}->loadMap();
                 $obj->{$fk[0]}->selfLoad($fkN,false);
               }
             }

            $resultArr[]=$obj;
          }

          foreach($this->mToN as $fk){
              $readObj=(new ReflectionClass($this->classTag.'_'.$fk[2]))->newInstance($this->classTag, $this->tableTag);
              $readObj->loadMap();
              
              $JOINstr="SELECT x.".$fk[3]." AS MAPid, y.* FROM ".$this->tableTag.'_'.$fk[1]." x JOIN ".$this->tableTag.'_'.$fk[2]." y ON x.".$fk[4]."= y.".$readObj->classID." WHERE x.".$fk[3]." IN (".implode(",",$IDs).")";
              $joinResult=$db->execute($JOINstr);
              foreach($resultArr as $res){
                $res->{$fk[0]}=array();
              }

              foreach($joinResult as $record){
                $properties=array();
                foreach($readObj->realArrVar as $prop){
                  $properties[$prop]=$record[$prop];
                }
                foreach($resultArr as $res){
                  if($res->{$this->classID}==$record["MAPid"]){
                    $res->{$fk[0]}[] = (new ReflectionClass($this->classTag.'_'.$fk[2]))->newInstance($this->classTag, $this->tableTag, $properties);
                  }
                }
              }
          }

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
