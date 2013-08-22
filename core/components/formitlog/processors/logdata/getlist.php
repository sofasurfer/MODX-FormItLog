<?php
/**
 * FormItLog 
 *
 * Returns all formit data
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */
 

 	/* path to data file */
	$logFile = $modx->getOption('logfile',$scriptProperties,$modx->getOption('formitlog.logfile'));

	/* get some additional params */
	$query = $modx->getOption('query',$scriptProperties,false);
	$start = $modx->getOption('start',$scriptProperties,0);
	$limit = $modx->getOption('limit',$scriptProperties,10); 	

	/* check if data file exist */
	if( file_exists($logFile) ){
	
		/* get comments from file */
		$formDataText = file_get_contents($logFile);
	
		/* create array list from jSon text file */
		$formDataList = json_decode($formDataText,true);		
	
		/* Loop Form Data */
		$list = array();
		$count = 0;
		foreach( $formDataList['formdata'] as $key => $value ){
		
			/**
			 * Check for search query
			 * I'm sure there is a nicer way to do this like with a filter
			 */
			if( $query==false || stripos($value['name'], $query) !== false 
				|| stripos($value['email'], $query) !== false
				|| stripos($value['subject'], $query) !== false
				|| stripos($value['message'], $query) !== false){
	
				/* Format LogTime */
				$formDataItem			= $value;
				$formDataItem['id']		= $key;
				$formDataItem['date']	= date("D, d M Y G:i:s T",$formDataItem['logtime']);
				$formDataItem['json']	= $modx->toJson( $value );
	
				$formDataItem['menu'] = array(
				array(
					'text' => $modx->lexicon('formitlog.action_update'),
					'handler' => 'this.update',
				),
				'-',
				array(
					'text' => $modx->lexicon('formitlog.action_delete'),
					'handler' => 'this.remove',
				));
	
				/* Add Item to List */
				$list[] = $formDataItem;
				
				$count++;
			}
		}
		
	}else{

		return $modx->error->failure( $modx->lexicon('formitlog.error_logfile',array('logfile'=>$logFile)) );

	}


	/* sort list by date */
	array_sort( $list,'!logtime');
	
	/* slice array for paging */
	$list = array_slice($list, $start, $limit);

	return $this->outputArray($list,$count) ;
	

	
/**
 * Function to Sort Array
 * @param $a The Array to Sort
 * @param &b The Fields to Sort
 */
function array_sort_func($a,$b=NULL) { 
   static $keys; 
   if($b===NULL) return $keys=$a; 
   foreach($keys as $k) { 
      if(@$k[0]=='!') { 
         $k=substr($k,1); 
         if(@$a[$k]!==@$b[$k]) { 
            return strcmp(@$b[$k],@$a[$k]); 
         } 
      } 
      else if(@$a[$k]!==@$b[$k]) { 
         return strcmp(@$a[$k],@$b[$k]); 
      } 
   } 
   return 0; 
} 

function array_sort(&$array) { 
   if(!$array) return $keys; 
   $keys=func_get_args(); 
   array_shift($keys); 
   array_sort_func($keys); 
   usort($array,"array_sort_func");        
}
