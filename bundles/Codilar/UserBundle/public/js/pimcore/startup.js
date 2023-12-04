pimcore.registerNS("pimcore.plugin.CodilarUserBundle");

pimcore.plugin.CodilarUserBundle = Class.create({
    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // Check if the user has specific permissions
        var user = pimcore.globalmanager.get("user");
        var permissions = user.permissions;

        if (permissions.indexOf("objects") !== -1) {

            alert("hello1");

            var navigationUl = Ext.get(Ext.query("#pimcore_navigation UL")).first();
            var existingMenuItem = Ext.getCmp('pimcore_menu_new-item');

            if (existingMenuItem) {
                existingMenuItem.destroy();
            }

            var newMenuItem = Ext.DomHelper.append(navigationUl, {
                tag: 'li',
                id: 'pimcore_menu_new-item',
                'data-menu-tooltip': 'User',
                cls: 'pimcore_menu_item icon-book_open',
                children: [
                    {
                        tag: 'img',
                        src: '/bundles/pimcoreadmin/img/flat-color-icons/person.svg'
                    }
                ]
            });

            Ext.get('pimcore_menu_new-item').on('click', function () {
                this.displayUserPanel();
            }, this);
        }
    },
    displayUserPanel: function () {
        var panel = new Ext.Panel({
            title: "User Details",
            closable: true,
            layout: 'fit',
            style: {
                height: '100%',
            },
            layoutConfig: {
                align: 'stretch',
            },
            items: [{
                xtype: 'grid',
                height: '100%',
                columns: [
                    { text: 'User ID', dataIndex: 'id', flex: 1 },
                    { text: 'User Name', dataIndex: 'name', flex: 1 },
                    { text: 'First Name', dataIndex: 'firstName', flex: 1 },
                    { text: 'Last Name', dataIndex: 'lastName', flex: 1 },
                    { text: 'Email ID', dataIndex: 'emailid', flex: 1 },
                    // {
                    //     text: 'API KEY',
                    //     dataIndex: 'apikey',
                    //     flex: 1,
                    //     editor: 'textfield',
                    //     renderer: function (value, metaData, record) {
                    //         if (!value) {
                    //             var newApiKey = md5(uniqid()) + md5(uniqid());
                    //             record.set('apikey', newApiKey);
                    //             return newApiKey;
                    //         }
                    //         return value;
                    //     }
                    // },
                    // {
                    //     text: 'API KEY',
                    //     dataIndex: 'apikey',
                    //     flex: 1,
                    //     editor: 'textfield',
                    //     renderer: function (value, metaData, record) {
                    //         var userId = record.get('id');
        
                    //         // Check if API key is already present in the records
                    //         if (value) {
                    //             return value;
                    //         } else {
                    //             // If not present, generate a new one
                    //             var newApiKey = md5(uniqid()) + md5(uniqid());
        
                    //             // Set the new API key to the record
                    //             record.set('apikey', newApiKey);
        
                    //             // Return the new API key
                    //             return newApiKey;
                    //         }
                    //     }
                    // },
                    {
                        text: 'API KEY',
                        dataIndex: 'apikey',
                        flex: 1,
                        editor: 'textfield',
                        renderer: function (value, metaData, record) {
                            var userId = record.get('id');
                    
                            // Check if API key is already present in the records
                            if (value) {
                                return value;
                            } else if (!record.get('apikeyFetched')) {
                                Ext.Ajax.request({
                                    url: '/get_api_key/' + userId, // Update the URL to your endpoint
                                    method: 'GET',
                                    success: function (response) {
                                        var apikey = Ext.decode(response.responseText).apikey;
                    
                                        // Set the fetched API key to the record
                                        record.set('apikey', apikey);
                                        record.set('apikeyFetched', true); // Mark that the API key has been fetched
                    
                                        // Refresh the grid to display the updated API key
                                        panel.down('grid').getView().refresh();
                                    },
                                    failure: function (response) {
                                        console.error('Failed to fetch API key');
                                    }
                                });
                    
                                // Display a loading message until the API key is fetched
                                return 'Loading...';
                            } else {
                                // API key has already been fetched, return a message or an empty string
                                return '';
                                // var newApiKey = md5(uniqid()) + md5(uniqid());
                                // record.set('apikey', newApiKey);
                            }
                        }
                    },
                    {
                        text: 'Action',
                        xtype: 'widgetcolumn',
                        widget: {
                            xtype: 'button',
                            icon: '/bundles/pimcoreadmin/img/flat-color-icons/flash_on.svg',
                            scale: 'small', 
                            style: {
                                background: 'transparent', 
                                border: 'none', 
                            },
                            handler: function (button) {
                                var record = button.getWidgetRecord();

                                var data = {
                                    id: record.get('id'),
                                    name: record.get('name'),
                                    firstName: record.get('firstName'),
                                    lastName: record.get('lastName'),
                                    emailid: record.get('emailid'),
                                    apikey: record.get('apikey')
                                };

                                Ext.Ajax.request({
                                    url: '/save_setting_data',
                                    method: 'POST',
                                    jsonData: data,
                                    success: function (response) {
                                        console.log('Data sent successfully');
                                    },
                                    failure: function (response) {
                                        console.error('Failed to send data');
                                    }
                                });

                            }
                        }
                    }
                ],
                store: Ext.create('Ext.data.Store', {
                    fields: ['id', 'name', 'firstName', 'lastName', 'emailid', 'apikey'],
                    autoLoad: true,
                    proxy: {
                        type: 'ajax',
                        url: '/users_detail',
                        reader: {
                            type: 'json',
                            rootProperty: 'list',
                        },
                    },
                }),
                plugins: {
                    ptype: 'cellediting',
                    clicksToEdit: 1,
                },
            }],
        });

        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        tabPanel.add(panel);
        tabPanel.setActiveItem(panel);
    }

});

var CodilarUserBundlePlugin = new pimcore.plugin.CodilarUserBundle();