pimcore.registerNS("pimcore.plugin.CodilarTrackingBundle");

pimcore.plugin.CodilarTrackingBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("CodilarTrackingBundle ready!");
    }
});

var CodilarTrackingBundlePlugin = new pimcore.plugin.CodilarTrackingBundle();
