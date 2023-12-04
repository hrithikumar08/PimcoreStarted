pimcore.registerNS("pimcore.plugin.CodilarMagentoConnectorBundle");

pimcore.plugin.CodilarMagentoConnectorBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("CodilarMagentoConnectorBundle ready!");
    }
});

var CodilarMagentoConnectorBundlePlugin = new pimcore.plugin.CodilarMagentoConnectorBundle();
