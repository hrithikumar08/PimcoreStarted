// pimcore.registerNS("pimcore.plugin.CodilarTrackingBundle");

// pimcore.plugin.CodilarTrackingBundle = Class.create({

//     initialize: function () {
//         document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
//     },

//     pimcoreReady: function (e) {
//         this.addButtonToSidebar();
//     },

//     addButtonToSidebar: function () {
//         // Find the sidebar container
//         var sidebar = Ext.getCmp('pimcore_navigation');
//         if (!sidebar) {
//             return;
//         }

//         // Create a new button
//         var newButton = Ext.create('Ext.button.Button', {
//             text: 'Hello',
//             iconCls: 'pimcore_icon_your_icon_class',
//             handler: function () {
//                 // Handle the button click event here
//                 alert("Button Clicked");
//             }
//         });

//         // Add the new button to the sidebar
//         sidebar.insert(1, newButton); // Adjust the position as needed (1 is just an example)
//     }
// });

// var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();



// pimcore.registerNS("pimcore.plugin.CodilarTrackingBundle");

// pimcore.plugin.CodilarTrackingBundle = Class.create({

//     initialize: function () {
//         document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
//     },

//     pimcoreReady: function (params,broker){
//         var extrasMenu = pimcore.globalmanager.get("layout_toolbar").extrasMenu;
//         console.log(extrasMenu);
//         if (!extrasMenu) {
//             return;
//             }


//         // if(extrasMenu){
//             extrasMenu.insert(extrasMenu.items.length+1, {
//                 text: t("plugin_pm"),
//                 iconCls: "plugin_pmicon",
//                 cls: "pimcore_main_menu",
//                 handler: this.showProcessManager.bind(this)
//             });

//             // ignore process manager process log request exceptions as otherwise annoying errors can pop up in the pimcore backend
//             Ext.Ajax.on({requestexception: function (conn, response, options) {
//                 if(response.request.url.startsWith('/admin/elementsprocessmanager/monitoring-item/list') && options.action === "read") {
//                     options.ignoreErrors = true;
//                 }
//             }, priority: 1000});
//         // }

//         // if(extrasMenu){
//             extrasMenu.updateLayout();
//         // }

//         // this.getConfig();
//     },

//     showProcessManager: function () {
//         var processManagerWindow = pimcore.element.get("processmanager");
//         if (processManagerWindow) {
//             processManagerWindow.show();
//         } else {
//             processManagerWindow = new pimcore.element.window({
//                 title: t("Process Manager"),
//                 width: 800,
//                 height: 600,
//                 modal: true,
//                 items: [
//                     new pimcore.element.processmanager({
//                         region: "center"
//                     })
//                 ]
//             });
    
//             processManagerWindow.show();
//         }
//     }


// });

// var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();

// pimcore.registerNS("pimcore.plugin.CodilarTrackingBundle");

// pimcore.plugin.CodilarTrackingBundle = Class.create({

//     initialize: function () {
//         document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
//     },

//     pimcoreReady: function (params,broker){
//         var extrasMenu = pimcore.globalmanager.get("layout_toolbar").extrasMenu;
//         console.log(extrasMenu);
//         if (!extrasMenu) {
//             return;
//         }

//         extrasMenu.insert(extrasMenu.items.length+1, {
//             text: "Alert Button",
//             iconCls: "pimcore_icon_pdf",
//             cls: "pimcore_main_menu",
//             handler: function() {
//                 alert("Button clicked!");
//             }
//         });

//         extrasMenu.updateLayout();
//     }
// });

// var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();

// Add the button to the sidebar
// pimcore.layout.get("west").add(new pimcore.element.button({
//     text: "Alert Button",
//     iconCls: "pimcore_icon_pdf",
//     cls: "pimcore_main_menu",
//     handler: function() {
//         alert("Button clicked!");
//     }
// }));


// pimcore.registerNS("pimcore.plugin.CodilarTrackingBundle");

// pimcore.plugin.CodilarTrackingBundle = Class.create({

//     initialize: function () {
//         document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
//     },

//     pimcoreReady: function (e) {
//         // Check if the user has specific permissions
//         var user = pimcore.globalmanager.get("user");
//         console.log(user);
//         var permissions = user.permissions;

//         if (permissions.indexOf("objects") !== -1) {
//             var navigationUl = Ext.get(Ext.query("#pimcore_navigation UL"));
//             var newMenuItem = Ext.DomHelper.createDom('<li id="pimcore_menu_new-item" data-menu-tooltip="Tracking" class="pimcore_menu_item icon-book_open"></li>');
//             navigationUl.appendChild(newMenuItem);
//             pimcore.helpers.initMenuTooltips();
//             var iconImage = document.createElement("img");
//             iconImage.src = "/bundles/pimcoreadmin/img/flat-color-icons/marker.svg";
//             newMenuItem.appendChild(iconImage);
//             newMenuItem.onclick = function () {
                
//                 // Make an AJAX request to call the controller action
//                 Ext.Ajax.request({
//                     url: '/tracking', // Update the URL to match your route
//                     method: 'GET',
//                     success: function (response) {
//                         // Handle the response here, e.g., display the view in a modal
//                         console.log(response.responseText);
//                         // You can open a modal or display the content in a panel
//                     },
//                     failure: function (response) {
//                         console.error("Failed to call the controller action");
//                     },
//                 });
//             };
//         }

//         alert("CodilarTrackingBundle ready!");
//     }
// });

// var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();





// OfflineAudioCompletionEvent


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
        }

        // alert("CodilarTrackingBundle ready!");
    },



    // displayTrackingPanel: function () {
    //     var panel = new Ext.Panel({
    //         title: "Tracking Details",
    //         width: 800,
    //         height: 400,
    //         layout: "fit",
    //         items: [{
    //             xtype: 'grid',
    //             columns: [
    //                 { text: 'User ID', dataIndex: 'userId' },
    //                 { text: 'Login Time', dataIndex: 'login' },
    //                 { text: 'Logout Time', dataIndex: 'logout' },
    //                 { text: 'Action Taken', dataIndex: 'action' },
    //                 { text: 'Action ID', dataIndex: 'objectId' }
    //             ],
    //             store: Ext.create('Ext.data.Store', {
    //                 proxy: {
    //                     type: 'ajax',
    //                     url: '/tracking' // Update the URL to match your route
    //                 },
    //                 fields: ['userId', 'login', 'logout', 'action', 'objectId'],
    //                 autoLoad: true
    //             })
    //         }]
    //     });
    
    //     // Show the panel as a tab in the Pimcore interface
    //     var tabPanel = Ext.getCmp("pimcore_panel_tabs");
    //     tabPanel.add(panel);
    //     tabPanel.setActiveItem(panel);
    
    //     // Make an AJAX request to load data into the grid
    //     var grid = panel.down('grid');
    //     var store = grid.getStore();
    //     store.load();
    // }

    displayTrackingPanel: function () {
        var panel = new Ext.Panel({
            title: "Tracking Details",
            width: 800,
            height: 400,
            layout: "fit",
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
    }
    
});

var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();


