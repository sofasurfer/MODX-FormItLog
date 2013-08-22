<?php
/**
 * FormItLog 
 *
 * Hook to store formit data to jSon file
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */
	    

	/* Get all form values */
	$formValues = $hook->getValues();
	
	/* Set additional values from snippet properties */	
	$formValues['email_to'] = $scriptProperties['emailTo'];
			 	

	/* Run Processor to add form data */
	$response = $modx->runProcessor('logdata/create',
		$formValues,
		array(
			'processors_path'   => MODX_CORE_PATH . 'components/formitlog/processors/'
		)
	);
	
	/* Check for errors */
	if ($response->isError()) {

		/* return error */
		$hook->addError("error_message",$response->getMessage() );
		return false;		
	}else{

		/* return hook is valid */
		return true;
	}