pimcore.registerNS("pimcore.plugin.CodilarTrackingBundle");

pimcore.plugin.CodilarTrackingBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // Check if the user has specific permissions
        var user = pimcore.globalmanager.get("user");
        var permissions = user.permissions;

        if (permissions.indexOf("objects") !== -1) {
            var navigationUl = Ext.get(Ext.query("#pimcore_navigation UL"));
            var newMenuItem = Ext.DomHelper.createDom('<li id="pimcore_menu_new-item" data-menu-tooltip="Tracking" class="pimcore_menu_item icon-book_open"></li>');
            navigationUl.appendChild(newMenuItem);
            pimcore.helpers.initMenuTooltips();
            var iconImage = document.createElement("img");
            iconImage.src = "/bundles/pimcoreadmin/img/flat-color-icons/marker.svg";
            newMenuItem.appendChild(iconImage);
            newMenuItem.onclick = this.displayTrackingPanel.bind(this);


            var newMenuItem1 = Ext.DomHelper.createDom('<li id="pimcore_menu_new-item2" data-menu-tooltip="Yaml" class="pimcore_menu_item pimcore_menu_needs_children true-initialized icon-server"></li>');
            navigationUl.appendChild(newMenuItem1);
            pimcore.helpers.initMenuTooltips();
            var iconImage = document.createElement("img");
            iconImage.src = "/bundles/pimcoreadmin/img/flat-color-icons/settings.svg";
            newMenuItem1.appendChild(iconImage);
            // newMenuItem1.onclick = function () {
            //     alert("hello");
            // };

            newMenuItem1.onclick = function () {
                // Perform an AJAX request to load data from the YAML file
                Ext.Ajax.request({
                    url: '/load-yaml-data', // Replace with the actual path to your YAML file
                    success: function (response) {
                        var yamlData = response.responseText;

                        try {
                            var parsedData = JSON.parse(yamlData);
                            // console.log(parsedData);

                            const submenu = new Ext.menu.Menu({
                                items: [{
                                    text: "Save Details",
                                    iconCls: "pimcore_nav_icon_doctypes",
                                    handler: function () {
                                        // Define the panel content
                                        var yamlPanel = new Ext.Panel({
                                            title: "Save Details",
                                            width: 400,
                                            height: 300,
                                            closable: true,
                                            layout: 'form',
                                            items: [
                                                {
                                                    xtype: 'fieldset',
                                                    title: "Inquiry",
                                                    collapsible: true,
                                                    collapsed: true,
                                                    autoHeight: true,
                                                    labelWidth: 300,
                                                    defaultType: 'textfield',
                                                    defaults: { width: 600 },
                                                    items: [
                                                        {
                                                            xtype: 'textfield',
                                                            fieldLabel: 'Name (Text)',
                                                            id: 'cname',
                                                            value: parsedData.general.cname
                                                        },
                                                        {
                                                            xtype: 'combo',
                                                            fieldLabel: 'Challan Type  (Select Dropdown)',
                                                            id: 'cselect',
                                                            queryMode: 'local',
                                                            mode: 'local',
                                                            editable: false,
                                                            store: Ext.create('Ext.data.Store', {
                                                                fields: ['value', 'display'],
                                                                data: [
                                                                    { value: 'b1', display: 'Bike Challan' },
                                                                    { value: 'c1', display: 'Car Challan' },
                                                                    { value: 't1', display: 'Truck Challan' }
                                                                ]
                                                            }),
                                                            displayField: 'display',
                                                            valueField: 'value',
                                                            forceSelection: true,
                                                            value: parsedData.general.cselect 
                                                        },
                                                        {
                                                            xtype: 'numberfield',
                                                            fieldLabel: 'Contact Number (Number)',
                                                            id: 'cnumber',
                                                            value: parsedData.general.cnumber 
                                                        }
                                                    ]
                                                },
                                                {
                                                    xtype: 'fieldset',
                                                    title: "Feedback",
                                                    collapsible: true,
                                                    collapsed: true,
                                                    autoHeight: true,
                                                    labelWidth: 300,
                                                    defaultType: 'textfield',
                                                    defaults: { width: 600 },
                                                    items: [
                                                        {
                                                            xtype: 'textfield',
                                                            fieldLabel: 'Feedback (Text)',
                                                            id: 'feed',
                                                            value: parsedData.feedback.feed
                                                        },
                                                        {
                                                            xtype: 'fieldcontainer',
                                                            fieldLabel: 'Rating',
                                                            defaultType: 'checkbox',
                                                            layout: 'hbox',
                                                            items: [
                                                                {
                                                                    boxLabel: '1',
                                                                    id: 'rating1',
                                                                    inputValue: '1',
                                                                    checked: parsedData.feedback.rating1
                                                                },
                                                                {
                                                                    boxLabel: '2',
                                                                    id: 'rating2',
                                                                    inputValue: '2',
                                                                    checked: parsedData.feedback.rating2
                                                                },
                                                                {
                                                                    boxLabel: '3',
                                                                    id: 'rating3',
                                                                    inputValue: '3',
                                                                    checked: parsedData.feedback.rating3
                                                                },
                                                                {
                                                                    boxLabel: '4',
                                                                    id: 'rating4',
                                                                    inputValue: '4',
                                                                    checked: parsedData.feedback.rating4
                                                                },
                                                                {
                                                                    boxLabel: '5',
                                                                    id: 'rating5',
                                                                    inputValue: '5',
                                                                    checked: parsedData.feedback.rating5
                                                                }
                                                            ]
                                                        }
                                                    ]
                                                }
                                            ],
                                            buttons: [
                                                {
                                                    text: 'Save',
                                                    iconCls: "pimcore_icon_apply",
                                                    handler: function () {
                                                        var cname = Ext.getCmp('cname').getValue();
                                                        var cselect = Ext.getCmp('cselect').getValue();
                                                        var cnumber = Ext.getCmp('cnumber').getValue();
                                                        var feed = Ext.getCmp('feed').getValue();
                                                        // var rating = Ext.getCmp('rating').getValue();

                                                        var rating1 = Ext.getCmp('rating1').getValue();
                                                        var rating2 = Ext.getCmp('rating2').getValue();
                                                        var rating3 = Ext.getCmp('rating3').getValue();
                                                        var rating4 = Ext.getCmp('rating4').getValue();
                                                        var rating5 = Ext.getCmp('rating5').getValue();

                                                        if(cname==null){
                                                            alert("Fill the name field");
                                                            return false;
                                                        }

                                                        if(cselect==null){
                                                            alert("Fill the Select field");
                                                            return false;
                                                        }
                                                        
                                                        if(cnumber==null){
                                                            alert("Fill the Number field");
                                                            return false;
                                                        }

                                                        // var ratings = Ext.ComponentQuery.query('checkbox[name=rating]');
                                                        // var selectedRatings = ratings.filter(rating => rating.getValue());

                                                        const data = {
                                                            general: {
                                                                cname: cname,
                                                                cselect: cselect,
                                                                cnumber: cnumber,
                                                            },
                                                            feedback: {
                                                                feed: feed,
                                                                // rating: selectedRatings,
                                                                rating1: rating1,
                                                                rating2: rating2,
                                                                rating3: rating3,
                                                                rating4: rating4,
                                                                rating5: rating5,
                                                            },
                                                        };

                                                        Ext.Ajax.request({
                                                            url: '/save-setting',
                                                            method: 'GET',
                                                            // url: Routing.generate('pimcore_save_settings'),
                                                            // method: "PUT",
                                                            params: {
                                                                data: Ext.encode(data)
                                                            },
                                                            success: function (response) {
                                                                var infoSave = Ext.decode(response.responseText);
                                                                if (infoSave.success) {
                                                                    Ext.Msg.alert('Success', 'Saved Success');
                                                                } else {
                                                                    Ext.Msg.alert("Data Not Saved");
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            ]
                                        });

                                        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
                                        tabPanel.add(yamlPanel);
                                        tabPanel.setActiveItem(yamlPanel);

                                    }
                                }, {
                                    text: "Testing",
                                    iconCls: "pimcore_nav_icon_website_settings",
                                }
                                ]
                            });
                            newMenuItem1.onclick = function () {
                                var cusmenu = Ext.get(newMenuItem1).getXY();
                                submenu.showAt([cusmenu[0] + newMenuItem1.offsetWidth, cusmenu[1]]);
                            };
                        } catch (error) {
                            console.error('Error parsing YAML:', error);
                        }
                    },
                    failure: function (response) {
                        console.error('Failed to load save.yaml');
                    }
                });

            };

        }

        // alert("CodilarTrackingBundle ready!");
    },
    displayTrackingPanel: function () {
        var panel = new Ext.Panel({
            title: "Tracking Details",
            width: 800,
            height: 400,
            layout: "fit",
            closable: true,
            items: [{
                xtype: 'grid',
                columns: [
                    { text: 'User ID', dataIndex: 'userId' },
                    { text: 'Login Time', dataIndex: 'login' },
                    { text: 'Logout Time', dataIndex: 'logout' },
                    { text: 'Action Taken', dataIndex: 'action' },
                    { text: 'Action ID', dataIndex: 'objectId' }
                ],
                store: Ext.create('Ext.data.Store', {
                    fields: ['userId', 'login', 'logout', 'action', 'objectId'],
                    autoLoad: true,
                    proxy: {
                        type: 'ajax',
                        url: '/tracking', // Update the URL to match your route
                        reader: {
                            type: 'json',
                            rootProperty: 'list', // Assuming your JSON response has a 'list' property
                        },
                    },
                }),
            }]
        });

        // Show the panel as a tab in the Pimcore interface
        var tabPanel = Ext.getCmp("pimcore_panel_tabs");
        tabPanel.add(panel);
        tabPanel.setActiveItem(panel);
    },



});

var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();