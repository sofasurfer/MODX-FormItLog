<?php
	/**
	 * FormItLog 
	 *
	 * Connector to access FormItLod processors
	 *
	 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
	 * @package formitlog
	 */

	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
	require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
	require_once MODX_CONNECTORS_PATH.'index.php';

	/* Check if user has permission to see logs */
	if (!$modx->hasPermission('logs')) {
		return $modx->error->failure($modx->lexicon('permission_denied'));
	}


	/* Load Lexicon entry */
	$modx->lexicon->load('formitlog:default'); 	
	
	/* Run Processor */
	$modx->request->handleRequest(array(
		'processors_path'   => MODX_CORE_PATH . 'components/formitlog/processors/',
		'location' => 'logdata'
	));
