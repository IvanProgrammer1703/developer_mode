<div class="object-selector-result-wrapper">
    <span class="object-selector-result">
    {$addon.name}

    {if ($addon.status == 'N')}
        <span><a class="alert-success cm-post" href="{$addon.install_url}">
            {__("install")}
            {* <i class="cm-post icon-refresh"></i> *}
        </a></span>
    {else}
        {if ($addon.delete_url)}
            <span><a class="alert-danger cm-post cm-confirm" href="{$addon.delete_url}">
                {__("uninstall")}
                {* <i class="cm-post cm-confirm icon-trash"></i> *}
            </a></span>
        {/if}
        {if ($addon.reinstall_url)}
            <span><a class="alert-info cm-post cm-confirm" href="{$addon.reinstall_url}">
                {__("addon_developer.reinstall")}
                {* <i class="cm-post cm-confirm icon-trash"></i> *}
            </a></span>
        {/if}
        {if ($addon.refresh_url)}
            <span><a class="cm-ad-object-addon cm-post" href="{$addon.refresh_url}">
                {__("refresh")}
                {* <i class="cm-post icon-refresh"></i> *}
            </a></span>
        {/if}
    {/if}
    </span>
</div>
