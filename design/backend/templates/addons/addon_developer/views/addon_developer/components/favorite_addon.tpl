
{if !$ajax_append}
<li class="addon-list-favorites__item addon-list-favorites-item" id="favorite-addon-{$addon.addon}">
{/if}
    {if $addon.urls.remove_from_fav}
        <a title="{__("addon_developer.remove_from_favorites")}" data-action="remove_from_fav" data-addon-id="{$addon.addon}" data-addon-name="{$addon.name}" class="cm-addon-developer-action-button icon-star-half-full" href="{$addon.urls.remove_from_fav}">
        </a>
    {/if}
    {if $addon.urls.install}
        <a title="{__("install")}" data-ca-target-id="favorite-addon-{$addon.addon}" class="cm-ajax alert-success cm-post icon-plus" href="{$addon.urls.install}">
        </a>
    {/if}
    {if $addon.urls.uninstall}
        <a title="{__("uninstall")}" data-ca-target-id="favorite-addon-{$addon.addon}" class="cm-ajax alert-danger cm-post cm-confirm icon-trash" href="{$addon.urls.uninstall}">
        </a>
    {/if}
    {if $addon.urls.reinstall}
        <a title="{__("addon_developer.reinstall")}" class="cm-ajax alert-info cm-post cm-confirm icon-trash" href="{$addon.urls.reinstall}">
        </a>
    {/if}
    {if $addon.urls.refresh}
        <a title="{__("refresh")}" class="cm-ajax cm-post icon-refresh" href="{$addon.urls.refresh}">
        </a>
    {/if}

    {if $addon.urls.toggle}
        <div data-addon-id="{$addon.addon}" class="switch switch-mini list-btns addon-list-favorites-item__switch cm-addon-developer-switch-change">
            <input type="checkbox" value="1" {if $addon.status == 'A'}checked="checked"{/if}/>
        </div>
    {/if}

    {if $addon.urls.update}
        <a class="hand cm-dialog-opener cm-ajax icon-cog"
            href={$addon.urls.update}
            id="opener_group{$addon.addon}installed"
            data-ca-target-id="content_group{$addon.addon}installed"
            data-ca-dialog-title="{__("settings")}: {$addon.name}"
            title="{__("settings")}"
        ></a>
    {/if}
    {if $addon.name}
        {$addon.name}
    {/if}
<!--favorite-addon-{$addon.addon}-->
{if !$ajax_append}
</li>
{/if}
