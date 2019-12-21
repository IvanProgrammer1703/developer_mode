<li class="addon-list-favorites__item">
    {if ($addon.urls.install)}
        <a title="{__("install")}" class="cm-ajax cm-addon-developer-action-button alert-success cm-post icon-plus" href="{$addon.urls.install}">
        </a>
    {/if}
    {if ($addon.urls.uninstall)}
        <a title="{__("uninstall")}" class="cm-ajax cm-addon-developer-action-button alert-danger cm-post cm-confirm icon-trash" href="{$addon.urls.uninstall}">
        </a>
    {/if}
    {if ($addon.urls.reinstall)}
        <a title="{__("addon_developer.reinstall")}" class="cm-ajax cm-addon-developer-action-button alert-info cm-post cm-confirm icon-trash" href="{$addon.urls.reinstall}">
        </a>
    {/if}
    {if ($addon.urls.refresh)}
        <a title="{__("refresh")}" class="cm-ajax cm-addon-developer-action-button cm-post icon-refresh" href="{$addon.urls.refresh}">
        </a>
    {/if}
    {if $addon.urls.toggle}
        <div data-addon-id="{$addon.addon}" class="switch switch-mini cm-addon-developer-switch-change list-btns">
            <input type="checkbox" value="1" {if $addon.status == 'A'}checked="checked"{/if}/>
        </div>
    {/if}
    {if ($addon.urls.update)}
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
</li>
