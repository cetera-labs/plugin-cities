Ext.define('Plugin.cities.List', {

    extend: 'Cetera.panel.Materials',
    title: 'Таблица',
    mat_type: 'cities',

    columns: [

        {header: "ID", width: 50, dataIndex: 'id'},
        {
            header: Config.Lang.title, width: 75, dataIndex: 'name', flex: 1,
            renderer: function (value, meta, rec) {
                if (rec.get('locked')) {
                    value += '<br><small>' + Ext.String.format(Config.Lang.materialLocked, rec.get('locked_login')) + '</small>';
                }
                return value;
            }
        },
        {header: "Alias", width: 175, flex: 1, dataIndex: 'alias'},
        {header: Config.Lang.date, width: 105, dataIndex: 'dat', renderer: Ext.util.Format.dateRenderer('d.m.Y H:i')},
        {header: Config.Lang.author, width: 100, dataIndex: 'autor'},
    ],

});