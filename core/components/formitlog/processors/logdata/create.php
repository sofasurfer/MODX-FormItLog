<?php
/**
 * FormItLog 
 *
 * Adds new entry to jSon file
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */
 
 	/* Load Lexicon entry */
	$modx->lexicon->load('formitlog:default');	
 
	/* path to data file */
	$logFile = $modx->getOption('logfile',$scriptProperties,$modx->getOption('formitlog.logfile'));

	/* get log data information */
	$logData = $scriptProperties;

	/* get form from file */
	$formText = file_get_contents($logFile);

	/* create array list from form */
	$formList = json_decode($formText,true);
	
	/* add some custom values */
	$logData['clientip'] = $_SERVER['REMOTE_ADDR'];
	$logData['context'] = $modx->context->key;
	$logData['logtime'] = time(); 
	
	/* add form data to array with micro time as key */
	$key =  $modx->context->key . "_" . microtime(true);
	$formList['formdata'][$key] = $logData;

	/* convert list back to jSon */
	$formText = json_encode($formList);

	/* save data to file */
	if( file_put_contents($logFile, $formText) == false ){

		/* Return error */
		return $modx->error->failure( $modx->lexicon('formitlog.error_logfile',array('logfile'=>$logFile)) );

	}else{
	
		/* Return new new entry */
		return $modx->error->success('',$product);	
	
	}
