
pimcore.registerNS("pimcore.plugin.CodilarCustomBundle");

pimcore.plugin.CodilarCustomBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("CodilarCustomBundle ready!");
    }
    
});

var CodilarCustomBundlePlugin = new pimcore.plugin.CodilarCustomBundle();


document.addEventListener(pimcore.events.postOpenObject, (e) => {
    if (e.detail.object.data.general.className === 'ProductStore') {
        e.detail.object.toolbar.add({
            text: t('Preview'),
            iconCls: 'pimcore_icon_pdf',
            scale: 'small',
            handler: function (obj) {
                const productId = e.detail.object.id;
                console.log(productId);
                const previewUrl = `/preview?id=${productId}`; // Adjust the URL as needed

                // Open a new browser tab with the preview URL
                window.open(previewUrl, '_blank');

                // const productId = e.detail.object.id;

                // // Make an AJAX request to your PreviewController
                // const xhr = new XMLHttpRequest();
                // xhr.open('GET', `/preview?id=${productId}`, true);

                // xhr.onload = function() {
                //     if (xhr.status === 200) {
                //         // Create a new window or tab and write the response content to it
                //         const newTab = window.open('', '_blank');
                //         newTab.document.open();
                //         newTab.document.write(xhr.responseText);
                //         newTab.document.close();
                //     }
                // };

                // xhr.send();

            //   // Get the ID from the object data
            //   var objectId = e.detail.object.id;

            //   // Send an AJAX request to your controller with the dynamic ID
            //   Ext.Ajax.request({
            //       url: '/preview', // Your controller route
            //       method: 'GET',
            //       params: {
            //           id: objectId
            //       },
            //       success: function (response) {
            //           // Create a new tab and set its content
            //         //   var previewTab = pimcore.globalmanager.get('previewTabPanel');
            //         //   previewTab.setActiveTab(
            //         //       previewTab.add({
            //         //           title: 'Preview',
            //         //           html: response.responseText
            //         //       })
            //         //   );

            //         const newTab = window.open('', '_blank');
            //         newTab.document.open();
            //         newTab.document.write(response);
            //         newTab.document.close();

            //       },
            //       failure: function (response) {
            //           // Handle AJAX request failure
            //           console.error('AJAX request failed');
            //       }
            //   });

            }.bind(this, e.detail.object)
        });
        pimcore.layout.refresh();
    }
});

// var apiDocumentUrl = 'http://localhost/en/Objects/Apis';
// var win = window.open(apiDocumentUrl, 'Preview API Document','width=800,height=600');

// $.ajax({
//     url: apiDocumentUrl,
//     method: 'GET',
//     success: function (response) {
//         win.document.write(response);
//     }
// });

// console.log('hello');
// window.open(apiDocumentUrl, '_blank');
// var apiDocumentUrl = 'http://localhost/en/Objects/Apis';
// window.open(apiDocumentUrl, '_blank');
// console.log(obj);


