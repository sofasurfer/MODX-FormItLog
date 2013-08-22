/**
 * Loads the FormData Panel
 * 
 * @author Kilian Bohnenblust <kilian@sofasurfer.org>
 * @class MODx.panel.FormData
 * @extends MODx.Component
 * @param {Object} config An object of config properties
 * @xtype modx-panel-formitlog
 */
MODx.panel.FormData = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'modx-panel-formitlog'
		,border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>' + _('formitlog.header') + '</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
			xtype: 'modx-tabs'
			,defaults: { border: false ,autoHeight: true }
			,border: true
			,items: [{
				title: _('formitlog.title')
				,defaults: { autoHeight: true }
				,items: [{
			        html: '<p>'+_('formitlog.desc')+'</p>'
			        ,border: false
			        ,bodyCssClass: 'panel-desc'
			    },{	        
					xtype: 'modx-grid-formitlog'
					,cls: 'main-wrapper'
					,preventRender: true
					,connector_url: config.connector_url
				}]

			}]
        }]
    });
    MODx.panel.FormData.superclass.constructor.call(this,config);
};
Ext.extend(MODx.panel.FormData,MODx.FormPanel);
Ext.reg('modx-panel-formitlog',MODx.panel.FormData);

