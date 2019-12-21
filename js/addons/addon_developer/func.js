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
                }
            });
            $.ceEvent('on', 'ce.ajaxdone', function() {
                $('.switch:not(.has-switch)').bootstrapSwitch();
            });
        });
    });

    $(_.doc).on('switch-change', '.cm-addon-developer-switch-change', function(e, data) {
        var value = data.value,
            $switch = $(this),
            addon_id = $switch.data('addonId'),
            url = $.sprintf('??&addon_id=??', [fn_url('addon_dev.toggle'), addon_id], '??');

        $.ceAjax('request', url, {
            method: 'post',
            data: {
                addon_id: addon_id,
                state: value ? 1 : 0
            },
            callback: function(data) {
                if (data['state_changed'] !== true) {
                    $switch.bootstrapSwitch('toggleState', true);
                }
            }
        });
        $.ceEvent('on', 'ce.ajaxdone', function() {
            $('.switch:not(.has-switch)').bootstrapSwitch();
        });
    });
}(Tygh, Tygh.$));