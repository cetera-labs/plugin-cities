Ext.require('Cetera.field.WidgetTemplate');
Ext.require('Cetera.field.Folder');

// Панелька виджета cities
Ext.define('Plugin.cities.Widget', {
    extend: 'Cetera.widget.Widget',

    saveButton: true,

    formfields: [
        {
            xtype: 'widgettemplate',
            widget: 'Cities'
        },
    ]

});