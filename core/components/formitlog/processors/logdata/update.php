<?php
/**
 * FormItLog 
 *
 * Update formit data entry
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */
 
 	/* path to data file */
	$itemId = $modx->getOption('id',$scriptProperties,false);
	$logFile = $modx->getOption('logfile',$scriptProperties,$modx->getOption('formitlog.logfile'));
 	

	/* check if data file exist */
	if( file_exists($logFile) == false ){
		return $modx->error->failure( $modx->lexicon('formitlog.error_filepath', array('filepath'=>$logFile)) );
	}
	
	/* get comments from file */
	$formDataText = file_get_contents($logFile);

	/* create array list from jSon text file */
	$formDataList = json_decode($formDataText,true);	

	if( empty($formDataList['formdata'][ $itemId ]) ){
		return $modx->error->failure( $modx->lexicon('formitlog.error_noentry', array('itemid'=>$itemId)) );
	}
	
	/* get form values */
	$formData = json_decode($scriptProperties['json'],true);
	$formData['email'] = $scriptProperties['email'];
	$formData['name'] = $scriptProperties['name'];
	
	/* update item by it */
	$formDataList['formdata'][ $itemId ] = $formData;
	
	/* convert form to string */
	$formText = json_encode($formDataList);

	/* save comment to file */
	if( file_put_contents($logFile, $formText) == false ){

		/* return error */
		$hook->addError("error_message",$modx->lexicon('formitlog.error_logfile', array('logfile'=>$logFile)) );
		return false;	

	}

	return $modx->error->success('',$itemId);

