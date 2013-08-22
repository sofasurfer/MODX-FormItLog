var topic = '/export/';
var register = 'formitlog';
var console = MODx.load({
   xtype: 'modx-console'
   ,register: register
   ,topic: topic
   ,show_filename: 0
   ,listeners: {
     'shutdown': {fn:function() {
         /* do code here when you close the console */
     },scope:this}
   }
});


/**
 * Loads the FormData List data grid
 * 
 * @author Kilian Bohnenblust <kilian@sofasurfer.org>
 * @class MODx.grid.FormData
 * @extends MODx.Component
 * @param {Object} config An object of config properties
 * @xtype modx-grid-formitlog
 */
MODx.grid.FormData = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: config.connector_url
        ,fields: ['id','context','subject','name','email','text','json','clientip','logtime','date','menu']
        ,paging: true
        ,autosave: true
        ,remoteSort: false
        ,columns: [{
            header: _('formitlog.header_id')
            ,dataIndex: 'id'
            ,width: 80
            ,hidden: true
            ,sortable: true
        },{
            header: _('formitlog.header_date')
            ,dataIndex: 'date'
            ,width: 90
            ,sortable: true
        },{
            header: _('formitlog.header_context')
            ,dataIndex: 'context'
            ,width: 50
            ,hidden: true
            ,sortable: true
        },{
            header: _('formitlog.header_subject')
            ,dataIndex: 'subject'
            ,width: 100
            ,sortable: true
        },{
            header: _('formitlog.header_name')
            ,dataIndex: 'name'
            ,width: 80
            ,sortable: true
        },{
            header: _('formitlog.header_email')
            ,dataIndex: 'email'
            ,width: 80
            ,sortable: true
        },{
            header: _('formitlog.header_text')
            ,dataIndex: 'text'
            ,width: 150
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('formitlog.header_clientip')
            ,dataIndex: 'clientip'
            ,width: 80
            ,sortable: true     
        }]
		,tbar: [{		
			xtype: 'textfield'
			,id: 'modx-filter-search-formitlog'
			,emptyText: _('search')
			,listeners: {
				'change': {fn:this.search,scope:this}
				,'render': {fn:function(tf) {
					tf.getEl().addKeyListener(Ext.EventObject.ENTER,function() {
					this.search(tf);
					},this);
				},scope:this}
			}			
		},'->',{
			xtype: 'button'
			,id: 'modx-button-export-formitlog'
			,text: _('formitlog.action_export')
			,listeners: {
				'click': {fn: this.exportData, scope: this}
			}			
		}]        
    });
    MODx.grid.FormData.superclass.constructor.call(this,config);
};
Ext.extend(MODx.grid.FormData,MODx.grid.Grid,{
    
    /* Search Data */
	search: function(tf,nv,ov) {
		this.getStore().baseParams = {
		    action: 'getList'
		    ,query: tf.getValue()
		};
		this.getBottomToolbar().changePage(1);
		this.refresh();
    } 
    
    /* Delete Data */
    ,remove: function() {
		MODx.msg.confirm({
		    title: _('formitlog.action_delete')
		    ,text: _('formitlog.confirm_delete') + this.menu.record.id
		    ,url: this.config.connector_url
		    ,params: {
			action: 'delete'
			,id: this.menu.record.id
		    }
		    ,listeners: {
			    'success': {fn:this.refresh,scope:this}
		    }
		});
	}
	
	/* Update Data */
	,update: function() {

		/* Get update window */
		var window = MODx.load({
			xtype: 'modx-window-formitlogdetail'
			,title: this.menu.record.subject
			,url: this.config.connector_url
			,listeners: {
				'success': {fn:function(r) {
					this.refresh();
				},scope:this}
			}
		});
		/* Set values from current record */
		window.setValues(this.menu.record);

		window.show(Ext.getBody());				
		//location.href = 'index.php?a='+MODx.action['controllers/formitlog']+'&id='+this.menu.record.id;
	}     	
	
    /* Export Data */
    ,exportData: function() {

		/* Fire up console */
      	console.show(Ext.getBody());

		/* Start export */
		MODx.Ajax.request({
			url: this.config.connector_url
			,params: {
				action: 'export'
				,register: register
				,topic: topic
			}
			,listeners: {
				'success':{fn:function() {
					console.fireEvent('complete');
				},scope:this}
			}
		});

	}	
});
Ext.reg('modx-grid-formitlog',MODx.grid.FormData);

