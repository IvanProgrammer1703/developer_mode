<div>

{capture "addon_list"}
{* <div style="background: white; position: fixed;"> *}
{* <div style="overflow-y: scroll; height: 200px;"> *}
    <div style="padding: 2px 5px" class="form-inline object-selector object-addon-add cm-object-addon-add-container">
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
            data-ca-dropdown-css-class="select2-dropdown-below-addon-add"
            { if $autofocus == "false" }
                { data-ca-autofocus="false" }
            { else }
                { data-ca-autofocus="true" }
            { /if }>
        </select>
    </div>
    <ul class="addon-list-favorites cm-favorite-addons">
    {foreach $favorite_addons as $addon}
        <li class="addon-list-favorites__item">
            {if ($addon.status == 'N')}
                <span><a class="alert-success cm-post icon-plus" href="{$addon.install_url}">

                </a></span>
            {else}
                {if ($addon.urls.uninstall)}
                    <span><a class="alert-danger cm-post cm-confirm icon-trash" href="{$addon.urls.uninstall}">
                    </a></span>
                {/if}
                {if ($addon.urls.reinstall)}
                    <span><a class="alert-info cm-post cm-confirm icon-trash" href="{$addon.urls.reinstall}">
                    </a></span>
                {/if}
                {if ($addon.urls.refresh)}
                    <span><a class="cm-pos icon-refresh" href="{$addon.urls.refresh}">
                    </a></span>
                {/if}
            {/if}
            {$addon.name}
        </li>
    {/foreach}
    </ul>
    {if !$favorite_addons}
        <div class="no-items">{__("no_items")}</div>
    {/if}

{* </div> *}
{* </div> *}
{/capture}

{dropdown
    content=$smarty.capture.addon_list
    class=""
    icon="icon-puzzle-piece icon-blue"
    no_caret=true
    text={__("addon_developer")}
}

</div>
