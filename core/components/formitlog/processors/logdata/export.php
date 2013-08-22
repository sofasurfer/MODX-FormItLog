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

	$query = $modx->getOption('query',$scriptProperties,false);
 	

	/* check if data file exist */
	if( file_exists($logFile) ){
	
		/* get comments from file */
		$formDataText = file_get_contents($logFile);
	
		/* create array list from jSon text file */
		$formDataList = json_decode($formDataText,true);		
	
		/* 
		 * Loop Form Data to get all value keys 
		 * Different forms can have different values
		 */
		$listKeys = array();
		foreach( $formDataList['formdata'] as $formDataValues ){
	
			//  Check if colum exist and add when not empty
			foreach( $formDataValues as $key => $value ){
				if( !in_array( $key, $listKeys ) && $value != "" ){
					array_push($listKeys, $key);
				}
			}

		}		
		
		/* Create csv file */		
		$exportPath = dirname( $modx->getOption('formitlog.logfile') ) . "/export/";
		$exportFile = $exportPath . "export_" . time() . ".csv";
		
		// check if path exist
		if( !file_exists($exportPath) ){
			if(mkdir($exportPath) == true){
				$modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon('formitlog.create_folder',array('folder'=>$exportPath)) );			
			}
		}
		
		$fp = fopen($exportFile, 'w');
		if( $fp ){
			
			/* Create header row with key values */
			fputcsv($fp, $listKeys);
		
			/* Loop data and add each row to file */
			foreach( $formDataList['formdata'] as $formDataValues ){
	
				$formDataRow = array();
				foreach( $listKeys as $key ){
					if( array_key_exists( $key, $formDataValues ) ){
						if( $key == 'logtime'){
							$formDataRow[$key] = date("D, d M Y G:i:s T",$formDataValues['logtime']);						
						}else{
							$formDataRow[$key] = $formDataValues[$key];
						}
					}else{
						$formDataRow[$key] = "";					
					}
				}
	
				/* Add Item to List */
				fputcsv($fp, $formDataRow);
			}

            /* Close csv file */
			fclose($fp);
			
			/* Show confirmation link */
			$fileUrl = str_replace( $modx->getOption('base_path'),$modx->getOption('base_url'),$exportFile);
			$modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon('formitlog.export_success',array('exportfile'=>$exportFile, 'url' => $fileUrl)) );
			
		}		
	}else{

		$modx->log( modX::LOG_LEVEL_ERROR, $modx->lexicon('formitlog.error_logfile',array('logfile'=>$logFile)) );

	}
	
	$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');