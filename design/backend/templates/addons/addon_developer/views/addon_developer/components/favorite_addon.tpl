<li class="addon-list-favorites__item">
    {if ($addon.urls.install)}
        <span><a data-action="install" class="cm-ajax cm-addon-developer-action-button alert-success cm-post icon-plus" href="{$addon.urls.install}">
        </a></span>
    {/if}
    {if ($addon.urls.uninstall)}
        <span><a data-action="uninstall" class="cm-ajax cm-addon-developer-action-button alert-danger cm-post cm-confirm icon-trash" href="{$addon.urls.uninstall}">
        </a></span>
    {/if}
    {if ($addon.urls.reinstall)}
        <span><a data-action="reinstall" class="cm-ajax cm-addon-developer-action-button alert-info cm-post cm-confirm icon-trash" href="{$addon.urls.reinstall}">
        </a></span>
    {/if}
    {if ($addon.urls.refresh)}
        <span><a data-action="refresh" class="cm-ajax cm-addon-developer-action-button cm-post icon-refresh" href="{$addon.urls.refresh}">
        </a></span>
    {/if}
    {if $addon.urls.enable || $addon.urls.disable}
        <div data-addon-id="{$addon.addon}" class="switch switch-mini cm-addon-developer-switch-change list-btns">
            <input type="checkbox" value="1" {if $addon.urls.disable}checked="checked"{/if}/>
        </div>
    {/if}
    {if $addon.name}
        {$addon.name}
    {/if}
</li>
