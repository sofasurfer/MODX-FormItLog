/**
 * Loads the FormData List page
 * 
 * @author Kilian Bohnenblust <kilian@sofasurfer.org>
 * @class MODx.page.FormData
 * @extends MODx.Component
 * @param {Object} config An object of config properties
 * @xtype modx-page-formitlog
 */
MODx.page.FormData = function(config) {
  
	config = config || {};
	Ext.applyIf(config,{
		components: [{
		    xtype: 'modx-panel-formitlog'
		    ,renderTo: 'modx-panel-formitlog-div'
		    ,connector_url: config.connector_url
		}]
	});
	MODx.page.FormData.superclass.constructor.call(this,config);
};
Ext.extend(MODx.page.FormData,MODx.Component);
Ext.reg('modx-page-formitlog',MODx.page.FormData);
