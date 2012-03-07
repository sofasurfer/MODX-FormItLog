<?php
/**
 * FormItLog 
 *
 * Returns formitlog manager
 *
 * @author Kilian Bohnenblust <kilian.sofasurfer.org>
 * @package formitlog
 */

	/*	set asset URL
		in development mode, set [[++formitlog.assets_url]] to the development directory
	 */
	$assetsUrl = $this->modx->getOption('formitlog.assets_url',null,$modx->getOption('assets_url').'components/formitlog/');

	/* register js classes */
	$modx->regClientStartupScript($assetsUrl.'js/modext/logdata-utils.js');
	$modx->regClientStartupScript($assetsUrl.'js/modext/logdata-grid.js');
	$modx->regClientStartupScript($assetsUrl.'js/modext/logdata-panel.js');
	$modx->regClientStartupScript($assetsUrl.'js/modext/logdata-page.js');
	
	/* load page when page ready and set connector url */
	$modx->regClientStartupHTMLBlock('<script type="text/javascript">
	Ext.onReady(function() {
		MODx.load({
			xtype: "modx-page-formitlog"
			,connector_url: "'.$assetsUrl.'connector.php"
		 });
	});

	</script>');

	/* Return the div to render the page to */
	return '<div id="modx-panel-formitlog-div"></div>';
