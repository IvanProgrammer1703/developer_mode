(function(_, $) {
    $.ceEvent('on', 'ce.change_select_list', function(object, elm) {

        if (elm.hasClass('cm-object-addon') && object.data) {

            object.context = object.data.content;
        }

        // if (elm.hasClass('cm-object-customer-add')) {
        //     var contextTemplate = '<table class="table-select2-customer"><tr><td class="table-select2-column-firstname-lastname">??</td></tr><tr><td class="table-select2-column-email">??</td></tr><tr><td class="table-select2-column-phone">??</td></tr></table>';

        //     var contextData = [
        //         object.text, object.email, object.phone
        //     ];
        //     object.context = $.sprintf(contextTemplate, contextData, '??');
        // }

    });

    $(document).ready(function() {

        // $(_.doc).on('change', '.cm-om-totals input:visible, .cm-om-totals select:visible, .cm-om-totals textarea:visible', function() {
        //     var is_changed = $('.cm-om-totals').formIsChanged();
        //     $('.cm-om-totals-price').toggleBy(is_changed);
        //     $('.cm-om-totals-recalculate').toggleBy(!is_changed);
        // });

        $('.cm-ad-object-addon').click(function() {
            var clicked = $(this);

        });

        $(_.doc).on('change', '.cm-object-addon', function() {
            var $container = $(this).closest('.cm-object-addon-add-container'),

                addon_name = $(this).val(),
                action = $(this).data('action'),
                // url = $.sprintf(
                //     '??&product_id=??&product_data[??][amount]=??', [fn_url('order_management.add'), product_id, product_id, 1],
                //     '??'
                // );
                // http: //localhost/cscart/admin.php?dispatch=order_management.add&product_id=12&product_data[12][amount]=1

                // url = $.sprintf(
                //     '??&addon_name=??', [fn_url('addons.add_to_fav'), addon_name],
                //     '??'
                // );

                url = $.sprintf(
                    '??&addon_name=??', [fn_url('addons.add_to_fav'), addon_name],
                    '??'
                );

            $container.find('input.select2-search__field').addClass('hidden');

            $.ceAjax('request', url, {
                method: 'post',
                result_ids: 'addon_name',
                full_render: true
            });

        });
    });

}(Tygh, Tygh.$));