<?php
/**
 * Resolves setup-options settings by setting log file path options.
 *
 * @package formitlog
 * @subpackage build
 */
	$success= false;
	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_INSTALL:
		case xPDOTransport::ACTION_UPGRADE:

		    /* logfile */
		    $setting = $object->xpdo->getObject('modSystemSetting',array('key' => 'formitlog.logfile'));
		    if ($setting != null) {
		        $setting->set('value',$options['logfile']);
		        $setting->save();
		    } else {
		        $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[FormItLog] logfile setting could not be found, so the setting could not be changed.');
		    }

		    $success= true;
		    break;
		case xPDOTransport::ACTION_UNINSTALL:
		    $success= true;
		    break;
	}
	return $success;
