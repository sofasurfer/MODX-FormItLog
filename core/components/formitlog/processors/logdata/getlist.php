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
 	

	/* check if data file exist */
	if( file_exists($logFile) ){
	
		/* get comments from file */
		$formDataText = file_get_contents($logFile);
	
		/* create array list from jSon text file */
		$formDataList = json_decode($formDataText,true);

		/* sort list by date */
		arsort($formDataList['formdata']);
	
		/* Loop Form Data */
		foreach( $formDataList['formdata'] as $key => $value ){

			/* Format LogTime */
			$formDataItem			= $value;
			$formDataItem['id']		= $key;
			$formDataItem['date']	= date("D, d M Y G:i:s T",$formDataItem['logtime']);

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
		}
		
	}else{

		return $modx->error->failure( $modx->lexicon('formitlog.error_logfile',array('logfile'=>$logFile)) );

	}


	return $this->outputArray($list,count($list)) ;
