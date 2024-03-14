Ext.define('Plugin.cities.Panel', {

    requires: ['Plugin.cities.List'],
    extend: 'Ext.tab.Panel',
    layout: 'fit',
    store: '',
    initComponent: function () {

        const panel = Ext.create('Plugin.cities.List');
        const formRobots = Ext.create('Plugin.cities.Robots');
        const formSitemap = Ext.create('Plugin.cities.Sitemap');
        const defaultCity = Ext.create('Plugin.cities.Settings');


        Ext.Ajax.request({
            url: '/plugins/cities/ajax.php',
            params: {
                action: 'getFiles',
            },
            success: function (response) {
                data = Ext.decode(response.responseText);
                if (data.res == true) {
                    formRobots.getForm().setValues(data);
                    formSitemap.getForm().setValues(data);
                    defaultCity.getForm().setValues(data);
                }
            }
        });


        Ext.apply(this, {
            items: [
                panel

            ]
        });
        this.callParent(arguments);
    }
});

