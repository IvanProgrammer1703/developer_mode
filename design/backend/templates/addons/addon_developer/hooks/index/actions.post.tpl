
{capture "addon_list"}

{if $show_addon_developer_menu}

{$drowpdown_icon = "addon-developer-dropdown__icon icon-puzzle-piece icon-blue"}

<div class="cm-ajax addon-developer-dropdown cm-addon-developer-container">
    <a href="{fn_url("addons.update&addon=addon_developer")}" class="addon-developer-dropdown__settings-button icon-cog"></a>
    <div class="addon-developer-dropdown__search form-inline object-selector object-addon-add">
        <select id="addon_select"
            class="cm-object-selector cm-object-addon"
            name="addon_list"
            data-ca-enable-images="true"
            data-ca-enable-search="true"
            data-ca-load-via-ajax="true"
            data-ca-page-size="10"
            data-ca-data-url="{fn_url("addons.get_addon_list") nofilter}"
            data-ca-placeholder="{__("type_to_search")}"
            data-ca-allow-clear="true"
            data-ca-ajax-delay="250"
            data-ca-close-on-select=true
            data-ca-dropdown-css-class="cm-addon-developer-dropdown__search-results"
            { if $autofocus == "false" }
                { data-ca-autofocus="false" }
            { else }
                { data-ca-autofocus="true" }
            { /if }
        >
        </select>
    </div>
    <ul class="addon-list-favorites cm-favorite-addons">
    {foreach $favorite_addons as $addon}
        {include "addons/addon_developer/views/addon_developer/components/favorite_addon.tpl"}
    {/foreach}
    </ul>
    {if !$favorite_addons}
        {__("no_items")}
    {/if}
</div>

{else}
    {$drowpdown_icon = "icon-remove"}
    <a class="addon-developer-dropdown__settings-button icon-cog" href="{fn_url("addons.update&addon=addon_developer")}"></a>{__("addon_developer.disabled_on_addons_page")}
{/if}

{/capture}

{dropdown
    content=$smarty.capture.addon_list
    class="addon-developer-dropdown"
    icon=$drowpdown_icon
    no_caret=true
    text={__("addon_developer")}
}
