Ext.define('Plugin.cities.Settings', {
    extend: 'Plugin.cities.Robots',
    title: 'Глобальные настройки',
    baseParams: {
        action: 'saveFields'
    },
    layout: {
        type: 'form',
        align: 'stretch'
    },
    padding: 10,

    requires: [
        'Ext.form.FieldContainer',
        'Ext.form.field.Text'
    ],
    items: [
        {
            xtype: 'fieldcontainer',

            items: [
                {
                    xtype: 'textfield',
                    name: 'server_city_key',
                    fieldLabel: _('IP ключ'),
                },
                {
                    xtype: 'textfield',
                    fieldLabel: 'Стандартный город',
                    name: 'default_city',
                },
                {
                    xtype: 'checkboxfield',
                    name: 'use_sitemap',
                    fieldLabel: _('Использовать sitemap'),
                }

            ]
        }

    ]


});