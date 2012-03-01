<?php
/**
 * FormItLog build script
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 * @subpackage build
 */
	 
	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$tstart = $mtime;
	set_time_limit(0); /* makes sure our script doesnt timeout */


	/* define package names */
	define('PKG_NAME','FormItLog');
	define('PKG_NAME_LOWER','formitlog');
	define('PKG_VERSION','0.0.1');
	define('PKG_RELEASE','beta');	

	$root = dirname(dirname(__FILE__)).'/';
	$sources= array (
		'root' => $root,
		'build' => $root .'_build/',
		'resolvers' => $root . '_build/resolvers/',
		'data' => $root . '_build/data/',
		'source_core' => $root.'core/components/'.PKG_NAME_LOWER . '/',
		'lexicon' => $root . 'core/components/'.PKG_NAME_LOWER.'/lexicon/',
		'source_assets' => $root.'assets/components/'.PKG_NAME_LOWER,
		'docs' => $root.'core/components/'.PKG_NAME_LOWER.'/docs/',
	);
	unset($root); /* save memory */

	/* Get MODX Class */
	require_once dirname(__FILE__) . '/build.config.php';
	require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
	 
	$modx= new modX();
	$modx->initialize('mgr');
	$modx->setLogLevel(modX::LOG_LEVEL_INFO);
	$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

	/* Load Package Transporter */
	$modx->loadClass('transport.modPackageBuilder','',false, true);
	$builder = new modPackageBuilder($modx);
	$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
	$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

	/* load action/menu */
	$menu = include $sources['data'].'transport.menu.php';
	 
	$vehicle= $builder->createVehicle($menu,array (
		xPDOTransport::PRESERVE_KEYS => true,
		xPDOTransport::UPDATE_OBJECT => true,
		xPDOTransport::UNIQUE_KEY => 'text',
		xPDOTransport::RELATED_OBJECTS => true,
		xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
		    'Action' => array (
		        xPDOTransport::PRESERVE_KEYS => false,
		        xPDOTransport::UPDATE_OBJECT => true,
		        xPDOTransport::UNIQUE_KEY => array ('namespace','controller'),
		    ),
		),
	));
	$builder->putVehicle($vehicle);
	unset($vehicle,$action); /* to keep memory low */


	/* load system settings */
	$settings = include $sources['data'].'transport.settings.php';
	 
	$attributes= array(
		xPDOTransport::UNIQUE_KEY => 'key',
		xPDOTransport::PRESERVE_KEYS => true,
		xPDOTransport::UPDATE_OBJECT => false,
	);
	foreach ($settings as $setting) {
		$vehicle = $builder->createVehicle($setting,$attributes);
		$builder->putVehicle($vehicle);
	}
	unset($settings,$setting,$attributes);

	/* create category */
	$category= $modx->newObject('modCategory');
	$category->set('id',1);
	$category->set('category',PKG_NAME);

	/* create the snippet */
	$snippet= $modx->newObject('modSnippet');
	$snippet->set('id',0);
	$snippet->set('name', 'FormItLog');
	$snippet->set('description', 'FormIt hook to store data to jSon.');
	$snippet->set('snippet',file_get_contents($sources['source_core'].'elements/snippets/hook.FormItLog.php'));

	/* se snippet properties */
	$properties = include $sources['data'].'properties.inc.php';
	$snippet->setProperties($properties);
	$category->addMany($snippet);



	/* add chunks */
	$chunks = include $sources['data'].'transport.chunks.php';
	if (is_array($chunks)) {
		$category->addMany($chunks);
	} else { $modx->log(modX::LOG_LEVEL_FATAL,'Adding chunks failed.'); }


	/* create category vehicle */
	$attr = array(
		xPDOTransport::UNIQUE_KEY => 'category',
		xPDOTransport::PRESERVE_KEYS => false,
		xPDOTransport::UPDATE_OBJECT => true,
		xPDOTransport::RELATED_OBJECTS => true,
		xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
		    'Snippets' => array(
		        xPDOTransport::PRESERVE_KEYS => false,
		        xPDOTransport::UPDATE_OBJECT => true,
		        xPDOTransport::UNIQUE_KEY => 'name',
		    ),
		    'Chunks' => array (
		        xPDOTransport::PRESERVE_KEYS => false,
		        xPDOTransport::UPDATE_OBJECT => true,
		        xPDOTransport::UNIQUE_KEY => 'name',
		    ),
		)
	);
	$vehicle = $builder->createVehicle($category,$attr);


	/* Script Validator */
	$vehicle->resolve('file',array(
		'source' => $sources['source_core'],
		'target' => "return MODX_CORE_PATH . 'components/';",
	));
	$vehicle->resolve('file',array(
		'source' => $sources['source_assets'],
		'target' => "return MODX_ASSETS_PATH . 'components/';",
	));
	$vehicle->resolve('php',array(
		'source' => $sources['resolvers'] . 'setupoptions.resolver.php',
	));
	$builder->putVehicle($vehicle);


	/* now pack in the license file, readme and setup options */
	$builder->setPackageAttributes(array(
		'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),	
		'license' => file_get_contents($sources['docs'] . 'license.txt'),
		'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
		'setup-options' => array(
		    'source' => $sources['build'] . 'setup.options.php'
		),
	));


	/* Build the package */
	$builder->pack();
	 
	$mtime= microtime();
	$mtime= explode(" ", $mtime);
	$mtime= $mtime[1] + $mtime[0];
	$tend= $mtime;
	$totalTime= ($tend - $tstart);
	$totalTime= sprintf("%2.4f s", $totalTime);
	 
	$modx->log(modX::LOG_LEVEL_INFO,"\nPackage Built.\nExecution time: {$totalTime}\n");
	exit();




