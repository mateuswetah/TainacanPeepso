// Checks if document is loaded
const tainacanPeepsoPerformWhenDocumentIsLoaded = callback => {
    if (/comp|inter|loaded/.test(document.readyState))
        cb();
    else
        document.addEventListener('DOMContentLoaded', callback, false);
}

tainacanPeepsoPerformWhenDocumentIsLoaded(() => {

    peepso.tainacan = {};

    /**
     * Form dialog add photos to album.
     * @param {number} user_id User ID.
     */
    peepso.tainacan.show_item_dialog = function (collectionId, itemId) {
        const TAINACAN_ITEM_EDITION_TEMPLATE = window.tainacanpeepso_itemeditiondialog && window.tainacanpeepso_itemeditiondialog.template;     
        const popup = peepso.dialog(TAINACAN_ITEM_EDITION_TEMPLATE, { wide: true }).show();
        popup.$el.addClass('ps-dialog-tainacan-edit-item');
        
        let iframeSrc = tainacan_plugin.admin_url + '/?itemEditionMode=true&hideItemEditionFocusMode=true&hideItemEditionFocusMode=true&hideItemEditionRequiredOnlySwitch=true&hideItemEditionThumbnail=true&hideItemEditionDocumentTextInput=true&hideItemEditionDocumentUrlInput=true&hideItemEditionPageTitle=true&page=tainacan_admin#/collections/';
        iframeSrc += collectionId + '/items/';

        if (itemId)
            iframeSrc += itemId + '/edit';
        else
            iframeSrc += 'new';

        let tainacanItemEditionIframe = popup.$el.find('iframe');
        tainacanItemEditionIframe[0].src = iframeSrc;
        
        window.addEventListener('message', function(event) {
            const message = event.message ? 'message' : 'data';
            const data = event[message];

            if (data.type == 'itemEditionMessage' && data.item !== null) {
                if (popup.$close)
                    popup.$close.click();
                
                document.dispatchEvent(new CustomEvent('TainacanReloadItemsListComponent'));
            }  
        });
    };

    // Ger collection id to be used in filter:
   // document.location.search.

    wp.hooks.addFilter('tainacan_faceted_search_item_before', 'tainacan-peepso', function(content, item) {
        return '<a href="#" onclick="peepso.tainacan.show_item_dialog(' + item.collection_id + ', ' + item.id + '); event.stopPropagation();">Edit</a>'
    });

});
