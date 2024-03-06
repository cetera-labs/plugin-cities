Ext.require('Cetera.field.WidgetTemplate');
Ext.require('Cetera.field.Folder');

// Панелька виджета cities.location
Ext.define('Plugin.cities.WidgetLocation', {
    extend: 'Cetera.widget.Widget',

    saveButton: true,

    formfields: [
        {
            fieldLabel: _('Список городов'),
            xtype: 'textfield',
            name: 'arrayCities',
            allowBlank: true
        },
        {
            xtype: 'checkboxfield',
            name: 'redirect',
            fieldLabel: _('Включить редирект'),
        },
        {
            xtype: 'checkboxfield',
            name: 'showmodalregion',
            fieldLabel: _('Показывать окно региона'),
        },
        {
            xtype: 'widgettemplate',
            widget: 'Cities.location'
        }
    ]

});