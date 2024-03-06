Ext.define('Plugin.cities.Robots', {
    title: 'Robots',

    extend: 'Ext.form.Panel',
    layout: 'fit',

    baseParams: {
        action: 'setRobots'
    },
    url: '/plugins/cities/ajax.php',

    defaults: {
        anchor: '100%',
    },

    defaultType: 'textareafield',

    items: [
        {
            name: 'robots_file'
        }
    ],
    buttons: [{
        text: 'Сохранить',
        handler: function () {
            var form = this.up('form').getForm();

            if (form.isValid()) {

                form.submit({
                    waitMsg: "Пожалуйста, подождите …",

                    failure: function (form, action) {
                        Ext.Msg.alert('Сообщение', action.response.responseText);

                    },
                });
            }
        }
    }],

});