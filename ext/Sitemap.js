Ext.define('Plugin.cities.Sitemap', {
    title: 'Sitemap',

    extend: 'Plugin.cities.Robots',
    baseParams: {
        action: 'setSitemap'
    },
    items: [
        {
            name: 'sitemap_file'
        }
    ]


});