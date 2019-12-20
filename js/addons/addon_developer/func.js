(function(_, $) {
    $.ceEvent('on', 'ce.change_select_list', function(object, elm) {

        if (elm.hasClass('cm-object-addon') && object.data) {

            object.context = object.data.content;
        }
    });

    $(document).ready(function() {
        $(_.doc).on('change', '.cm-object-addon', function() {
            var container = $(this).closest('.cm-addon-developer-container'),
                addon_id = $(this).val(),
                url = $.sprintf('??&addon_id=??', [fn_url('addon_dev.add_to_fav'), addon_id], '??'),
                favoriteList = container.find('.cm-favorite-addons'),
                searchResults = $('.cm-addon-developer-dropdown__search-results'),
                selected = searchResults.find('li.select2-results__option--highlighted'),
                searchInput = container.find('#select2-addon_select-container');
            container.find('input.select2-search__field').addClass('hidden');

            var data = {
                addon_id: addon_id
            };
            $.ceAjax('request', url, {
                method: 'post',
                data: data,
                append: true,
                overlay: '.cm-addon-developer-container',
                callback: function(data) {
                    favoriteList.append(data['response']);
                    selected.remove();
                    searchInput.empty();
                    //TODO: move to ajaxdone event
                    $('.switch:not(.has-switch)').bootstrapSwitch();
                }
            });
        });
    });

    // }(Tygh, Tygh.$));
    //FIXME: Separate functions or not?
    // (function(_, $) {

    $(_.doc).on('switch-change', '.cm-addon-developer-switch-change', function(e, data) {

        var value = data.value,
            addon_id = $(this).data('addonId'),
            url = $.sprintf('??&addon_id=??', [fn_url('addon_dev.toggle'), addon_id], '??');
        console.log(value);
        console.log(addon_id);

        $.ceAjax('request', url, {
            method: 'post',
            data: {
                addon_id: addon_id,
                state: value ? 1 : 0
            }
        });
    });

    $.ceEvent('on', 'ce.ajaxdone', function() {

        if ($('.switch .switch-mini').length == 0) {
            $('.switch')['bootstrapSwitch']();
        }
    });
}(Tygh, Tygh.$));