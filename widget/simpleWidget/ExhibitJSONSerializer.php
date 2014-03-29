<?php

class ExhibitJSONSerializer {

	const DC = 'http://purl.org/dc/elements/1.1/';
	const RDFS = 'http://www.w3.org/2000/01/rdf-schema#';
	const FOAF = 'http://xmlns.com/foaf/0.1/';
	const FOAF_SPEC = 'http://xmlns.com/foaf/spec/';
	const RDF = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';
	const XSD = 'http://www.w3.org/2001/XMLSchema#';
	const RSS = 'http://purl.org/rss/1.0/';
	const OWL = 'http://www.w3.org/2002/07/owl#';


	var $lang = false;

  function __construct($a = '') {
	if(isset($a['lang'])) $this->lang = $a['lang'];
  }
  
  function ExhibitJSONSerializer($a = '') {
    $this->__construct($a);
  }

  function __init() {
  }

	function get_label($props)
	{
		/* priorized from up to down */
		$title_candidates = array(
		    'http://www.w3.org/2004/02/skos/core#prefLabel',
			self::DC.'title',
			self::RSS.'title',
			self::FOAF.'name',
			self::RDFS.'label',
			'http://schemas.talis.com/2005/service/schema#name',
			self::FOAF.'mbox',
			);

		//try in this language
		foreach($title_candidates as $title_prop){
			if(isset($props[$title_prop])){
				if($this->lang){
					foreach($props[$title_prop] as $obj){
						if(isset($obj['lang']) AND $obj['lang']==$this->lang){
							return $obj['value'];
						}
					}
				}
				
				return $props[$title_prop][0]['value'];					
			}
		}
		return false;
	}



	function split_uri($term_uri){
		preg_match('@^(.+?[/#])([^/#]+)$@',$term_uri, $p_match);
		array_shift($p_match);
		return  $p_match;
	}
	
	
	function uri_to_term($uri){
		$term =  array_pop($this->split_uri($uri));
		return $term;
	}
	
	function uri_to_label($uri){
		$term = $this->uri_to_term($uri);
		return ucwords(preg_replace('/([a-z])([A-Z])/','$1 $2', str_replace('_','',$term)));
	}
	
	function getSerializedIndex($resources){
	
		/* this is the template of the exhibitJSON data structure */
		$exhibit = array(
					'items' 	 => array(),
					
					'properties' => array(

						'label'=> array(
									'uri'=> 'http://www.w3.org/2000/01/rdf-schema#label'
									),
						
						),
						
					'types' => array(
						
						'item' => array(
							'label' => 'Item',
							'pluralLabel' => 'Items',
							),
						),
					); 
		
		/* fill the template */
		foreach($resources as $uri => $properties) //each uri has an array of properties, each property has an array of objects
		{
			/* determine if resource has a type and if any convert its name and add it to exhibit types array */
			if(isset($properties['http://www.w3.org/1999/02/22-rdf-syntax-ns#type']))
			{
				$rdf_type = $properties['http://www.w3.org/1999/02/22-rdf-syntax-ns#type'][0]['value'];
				$rdf_type_term = $this->uri_to_term($rdf_type);
				$exhibit['types'][$rdf_type_term] = array('label'=> $this->uri_to_label($rdf_type), );				
			}
			/* create new item and set label and type of it */
			$label = $this->get_label($properties);
			$item = array(
				'id' => $uri,
				'label' => ($label) ? $label : '!!!!LABEL MISSING',
				'type' =>  (!empty($rdf_type_term))? $rdf_type_term : 'item',
				);
			
			/* determine properties of resource and add it to exhibit properties array  */
			foreach($properties as $property => $objects)
			{
				/* convert name of the property and add it to exhibit properties array IF NOT ALREADY DONE */
				$qname = $this->uri_to_term($property);
				if(!isset($exhibit['properties'][$qname]))
				{
					$exhibit['properties'][$qname] = array(
							'uri' => $property,
							'label' => $this->uri_to_label($property),
						);
				}
					
				/* determine the valuetype and the values of the property */
				$values = array();
				foreach($objects as $object)
				{
					//if ($qname=='hasSupplier' && isset($resources[$object['value']])) print "OOOOH";
					/* TYPE-MAPPING */
					switch(true)
					{
						default :
							if (!isset($exhibit['properties'][$qname]['valueType']))
								$valuetype = 'text';
							else
								$valuetype = $exhibit['properties'][$qname]['valueType'];
							break;
						case (empty($object['datatype']) AND $object['type']=='literal' AND !$this->isOtherType($property,$object) AND $this->hasHigherPriority('text',$exhibit['properties'][$qname]['valueType'] ) ):
							$valuetype = 'text';
							break;
						case (isset($resources[$object['value']]) AND ($object['type']=='uri' OR $object['type']=='iri')) :
							$valuetype = 'item'; 
							break;																								//or the value is an URL              in any case type should not been determined as item in the past 								
						case (!isset($resources[$object['value']]) AND ($object['type']=='uri' OR $object['type']=='iri' OR $this->isValidURL($object['value'])) AND $this->hasHigherPriority('url',$exhibit['properties'][$qname]['valueType'])  ): // last 3 conditions prevent overwriting valuetype from item to url if to an uri no resource exists
							$valuetype = 'url';																												
							break;
						case (isset($object['datatype']) AND $object['datatype'] == self::XSD.'int') :
							$valuetype = 'number';
							break;
						case ( (isset($object['datatype']) AND $object['datatype'] == self::XSD.'date') OR $this->isDateProperty($property) ) : ## last or condition to solve problems with ical
							$valuetype = 'date';
							break;
						case (isset($object['datatype']) AND $object['datatype'] == self::XSD.'boolean') :
							$valuetype = 'boolean';
							break;						
					}
						if (isset($valuetype)) $exhibit['properties'][$qname]['valueType'] = $valuetype;
						$values[]=$object['value'];
				}
				
				/* add values of the property to the item */
				if (!($property =='http://www.w3.org/1999/02/22-rdf-syntax-ns#type'))## added condition otherwise [type] would be overwritten by object instead of  converted exhibit json type name
				{
					if(count($values)==1) {$item[$qname] = $values[0];}
					else $item[$qname] = $values;
				}
			}
			
			$exhibit['items'][]=$item;
		}
		return json_encode($exhibit);
	}
	
	
	#########################################################################
	## checks wheter the predicate is an date predicate to set the value of the corresponding property to date
	## solves the problem if date-objects don't have a date type
	function isDateProperty($prop)
	{
		switch(true)
						{
							default : 
								$result = false;
								break;
							case ($prop == 'http://www.w3.org/2002/12/cal/ical#dtstart') :
								$result = true;
								break;
							case ($prop == 'http://www.w3.org/2002/12/cal/ical#dtend') :
								$result = true;
								break;		
						}
		return $result;
	}
	
	#########################################################################
	## use in type-mapping switch to check if already a type has been detected for a property which has a higher
	## prioritiy, thus e.g. a property with the type item won't be overwritten by the type url if for some object value no item exists
	function hasHigherPriority($typeCase,&$lastType)
	{
		if (isset($lastType))
		{
			$result = true;
			switch($typeCase)
						{
							default :
								break;
							case 'url' :				//url has lower priority than item
								if($lastType=='item') 
									$result = false;
								break;
							case 'item' :				//item has highest priority 
								break;
							case 'text' :
								if($lastType=='text')	//text has lowest priority
									$result = true;
								else $result = false;
								break;	
						}
			return $result;
		}
		else
			return true;
	}
	
	function isValidURL($url)
	{
		if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) > 0)
			return true;
		else
			return false;
	}
	
	/*  */
	function isOtherType($prop,$obj)
	{	
		if($this->isDateProperty($prop) OR $this->isValidURL($obj['value']))
			return true;
		else
			return false;
	}

}



?>