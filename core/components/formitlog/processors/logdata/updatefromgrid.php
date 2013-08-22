<?php
/**
 * FormItLog 
 *
 * Update formit data from grid inline edit
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */
 
 	 /* Get data */
	$_DATA = $modx->fromJSON($scriptProperties['data']);
	
 	/* path to data file */
	$logFile = $modx->getOption('logfile',$scriptProperties,$modx->getOption('formitlog.logfile'));
 	
	/* check if data file exist */
	if( file_exists($logFile) == false ){
		return $modx->error->failure( $modx->lexicon('formitlog.error_filepath', array('filepath'=>$logFile)) );
	}
	
	/* get comments from file */
	$formDataText = file_get_contents($logFile);

	/* create array list from jSon text file */
	$formDataList = json_decode($formDataText,true);	

	if( empty($formDataList['formdata'][ $_DATA['id'] ]) ){
		return $modx->error->failure( $modx->lexicon('formitlog.error_noentry', array('itemid'=>$itemId)) );
	}
	
	/* make sure extra json data are removed */
	unset($_DATA['json']);
	
	/* update data */
	$formDataList['formdata'][ $_DATA['id'] ] = array_merge($formDataList['formdata'][ $_DATA['id'] ],$_DATA);
	
	/* convert form to string */
	$formText = json_encode($formDataList);

	/* save comment to file */
	if( file_put_contents($logFile, $formText) == false ){

		/* return error */
		$hook->addError("error_message",$modx->lexicon('formitlog.error_logfile', array('logfile'=>$logFile)) );
		return false;	

	}

	return $modx->error->success('',$itemId);

