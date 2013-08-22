
/**
 * Set FormItLogType Combo
 * 
 * @class MODx.combo.LogType
 * @extends Ext.form.ComboBox
 * @param {Object} config An object of configuration properties
 * @xtype modx-combo-logtype
 */
MODx.combo.FormItLogType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'formitlog-type'
        ,hiddenName: 'products-type'
        ,displayField: 'name'
        ,valueField: 'id'
        ,fields: ['name','id']
        ,url: MODx.config.connectors_url+'mdws/products-type.php'
        ,baseParams: {
            action: 'getList',
            active: 1,
	    namevalue: true
        }
    });
    
    MODx.combo.FormItLogType.superclass.constructor.call(this,config);
};
Ext.extend(MODx.combo.FormItLogType,MODx.combo.ComboBox);
Ext.reg('modx-combo-formitlog-type',MODx.combo.FormItLogType);



/**
 * Set FormItLogDetail Window
 * 
 * @class MODx.window.LogType
 * @extends Ext.form.Window
 * @param {Object} config An object of configuration properties
 * @xtype modx-window-formitlogdetail
 */
 MODx.window.FormItLogDetail = function(config) {
    config = config || {};
    this.ident = config.ident || 'ccat'+Ext.id();
    Ext.applyIf(config,{
        title: _('mdws.window_products-type')
        ,id: this.ident
        ,height: 150
        ,width: 450
        ,url: config.connector_url
        ,action: 'update'
		,listeners: {
			'success': {fn:function(r) {
				this.refresh();
			},scope:this}
		}        
        ,fields: [{
            fieldLabel: _('formitlog.header_id')
            ,name: 'id'
            ,id: 'modx-'+this.ident+'-id'
            ,xtype: 'textfield'
            ,hidden: true
        },{
            fieldLabel: _('formitlog.header_name')
            ,name: 'name'
            ,id: 'modx-'+this.ident+'-name'
            ,xtype: 'textfield'
            ,anchor: '90%'
        },{
            fieldLabel: _('formitlog.header_email')
            ,name: 'email'
            ,id: 'modx-'+this.ident+'-email'
            ,xtype: 'textfield'
            ,anchor: '90%'
        },{
            fieldLabel: _('formitlog.description')
            ,name: 'json'
            ,id: 'modx-'+this.ident+'-description'
            ,xtype: 'textarea'
            ,anchor: '90%'
        }]
    });
    MODx.window.FormItLogDetail.superclass.constructor.call(this,config);
};
Ext.extend(MODx.window.FormItLogDetail,MODx.Window);
Ext.reg('modx-window-formitlogdetail',MODx.window.FormItLogDetail);







