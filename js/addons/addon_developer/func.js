(function(_, $) {
    $.ceEvent('on', 'ce.change_select_list', function(object, elm) {

        if (elm.hasClass('cm-object-addon') && object.data) {

            object.context = object.data.content;
        }
    });

    $(document).ready(function() {
        $(_.doc).on('change', '.cm-object-addon', function() {
            var $container = $(this).closest('.cm-object-addon-add-container'),
                $form = $container.closest('.addon-developer-dropdown__form'),
                addon_code = $(this).val(),
                action = $(this).data('action'),
                url = $.sprintf(
                    '??&addon_code=??', [fn_url('addons.add_to_fav'), addon_code],
                    '??'
                );

            $container.find('input.select2-search__field').addClass('hidden');
            var favoriteList = $form.find('.cm-favorite-addons');

            var data = {
                addon_code: addon_code
            };
            $.ceAjax('request', url, {
                method: 'post',
                data: data,
                append: true,
                overlay: '.cm-favorite-addons',
                callback: function(data) {
                    favoriteList.append(data['response']);
                }
            });
        });
    });

}(Tygh, Tygh.$));