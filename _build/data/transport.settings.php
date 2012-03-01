<?php
	$s = array(
		'logfile' => '{assets_path}components/formitlog/data/formitlog.json',

	);

	$settings = array();

	foreach ($s as $key => $value) {
		if (is_string($value) || is_int($value)) { $type = 'textfield'; }
		elseif (is_bool($value)) { $type = 'combo-boolean'; }
		else { $type = 'textfield'; }

		$settings['bdlistings.'.$key] = $modx->newObject('modSystemSetting');
		$settings['bdlistings.'.$key]->set('key', PKG_NAME_LOWER.'.'.$key);
		$settings['bdlistings.'.$key]->fromArray(array(
		    'value' => $value,
		    'xtype' => $type,
		    'namespace' => PKG_NAME_LOWER,
		    'area' => 'Default'
		));
	}

	return $settings;
