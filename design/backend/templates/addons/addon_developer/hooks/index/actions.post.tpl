{capture "addon_list"}

{if $show_addon_developer_menu}

{$drowpdown_icon = "addon-developer-dropdown__icon icon-puzzle-piece icon-blue"}

<div class="addon-developer-dropdown-menu cm-addon-developer-container">

    <a class="hand cm-dialog-opener cm-ajax addon-developer-dropdown__settings-button icon-cog"
        href="{$addon_developer_settings_url}"
        id="opener_group{$addon.addon}installed"
        data-ca-target-id="content_group{$addon.addon}installed"
        data-ca-dialog-title="{__("settings")}: {$addon.name}"
        title="{__("settings")}"
    ></a>

    <div class="addon-developer-dropdown__search form-inline object-selector object-addon-add">
        <select id="addon_select"
            class="cm-object-selector cm-object-addon"
            name="addon_list"
            data-ca-enable-search=true
            data-ca-load-via-ajax=true
            data-ca-data-url="{fn_url("addon_dev.get_addon_list") nofilter}"
            data-ca-placeholder="{__("type_to_search")}"
            data-ca-allow-clear=true
            data-ca-ajax-delay="250"
            data-ca-close-on-select=true
            data-ca-dropdown-css-class="cm-addon-developer-dropdown__search-results"
        >
        </select>
    </div>
    <ul class="addon-list-favorites cm-favorite-addons">
        {foreach $favorite_addons as $addon}
            {include "addons/addon_developer/views/addon_developer/components/favorite_addon.tpl"}
        {/foreach}
        <div class="addon-list-favorites__no-items{if $favorite_addons} hidden{/if}">
            {__("no_items")}
        </div>
    </ul>
</div>

{else}
    {$drowpdown_icon = "icon-remove"}
    {__("addon_developer.disabled_on_addons_page")}
{/if}

{/capture}

{dropdown
    content=$smarty.capture.addon_list
    class="addon-developer-dropdown"
    icon=$drowpdown_icon
    no_caret=true
    text={__("addon_developer")}
    placement="right"
}
