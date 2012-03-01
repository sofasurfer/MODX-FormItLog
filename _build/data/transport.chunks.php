<?php
	/**
	* @package formitlog
	* @subpackage build
	*/
	$chunks = array();


	$chunks[1]= $modx->newObject('modChunk');
	$chunks[1]->fromArray(array(
		'id' => 1,
		'name' => 'ContactForm-Log',
		'description' => 'Example Contact form wit logging.',
		'snippet' => file_get_contents($sources['source_core'].'elements/chunks/chunk.ContactForm.html'),
	),'',true,true);
	 

	return $chunks;
