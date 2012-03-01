<?php
	$action= $modx->newObject('modAction');
	$action->fromArray(array(
		'id' => 1,
		'namespace' => PKG_NAME_LOWER,
		'parent' => 0,
		'controller' => 'controllers/index',
		'haslayout' => true,
		'lang_topics' => PKG_NAME_LOWER.':default',
		'assets' => '',
	),'',true,true);
	 
	$menu= $modx->newObject('modMenu');
	$menu->fromArray(array(
		'text' => 'FormIt - Logs',
		'parent' => 'components',
		'description' => PKG_NAME_LOWER.'.desc',
		'icon' => 'images/icons/plugin.gif',
		'menuindex' => 0,
		'params' => '',
		'handler' => '',
	),'',true,true);
	$menu->addOne($action);
	unset($menus);
	 
	return $menu;
