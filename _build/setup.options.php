<?php
/**
 * Build the setup options form.
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 * @subpackage build
 */
 
	/* set some default values */
	$values = array(
		'logfile' => '{assets_path}components/formitlog/formitlog.json',
	);
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:
		    $setting = $modx->getObject('modSystemSetting',array('key' => 'formitlog.logfile'));
		    if ($setting != null) { $values['logfile'] = $setting->get('value'); }
		    unset($setting);
		break;
		case xPDOTransport::ACTION_UNINSTALL: break;
	}
	 
	$output = '<label for="quip-emailsTo">Path to log file (WARNING: this file is accessible from the web, if no access rule is defined):</label>
	<input type="text" name="logfile" id="formitlog-logfile" width="300" value="'.$values['logfile'].'" />
	<br /><br />';
	 
	return $output;
