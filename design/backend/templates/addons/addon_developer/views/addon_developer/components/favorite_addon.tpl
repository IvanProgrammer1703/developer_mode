<li class="addon-list-favorites__item">
    {if ($addon.urls.install)}
        <span><a class="cm-ajax alert-success cm-post icon-plus" href="{$addon.urls.install}">
        </a></span>
    {/if}
    {if ($addon.urls.uninstall)}
        <span><a class="cm-ajax alert-danger cm-post cm-confirm icon-trash" href="{$addon.urls.uninstall}">
        </a></span>
    {/if}
    {if ($addon.urls.reinstall)}
        <span><a class="cm-ajax alert-info cm-post cm-confirm icon-trash" href="{$addon.urls.reinstall}">
        </a></span>
    {/if}
    {if ($addon.urls.refresh)}
        <span><a class="cm-ajax cm-post icon-refresh" href="{$addon.urls.refresh}">
        </a></span>
    {/if}
    {if ($addon.urls.enable)}
        <span><a class="cm-ajax cm-post icon-plus" href="{$addon.urls.enable}">
        </a></span>
    {/if}
    {if ($addon.urls.disable)}
        <span><a class="cm-ajax cm-post icon-minus" href="{$addon.urls.disable}">
        </a></span>
    {/if}
    {if $addon.name}
        {$addon.name}
    {/if}
</li>
