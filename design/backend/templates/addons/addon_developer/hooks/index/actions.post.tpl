<div>

{capture "addon_list"}
<div style="background: white; position: fixed;">
    <div style="overflow-y: scroll; height: 200px;">
    {foreach $addon_list as $addon}
        <li style="padding: 2px 5px">
            {$addon.name}

            {if ($addon.status == 'N')}
                <span><a class="alert-success cm-post" href="{$addon.install_url}">
                    {__("install")}
                </a></span>
            {else}
                {if ($addon.delete_url)}
                    <span><a class="alert-danger cm-post cm-confirm" href="{$addon.delete_url}">
                        {__("uninstall")}
                    </a></span>
                {/if}
                {if ($addon.reinstall_url)}
                    <span><a class="alert-info cm-post cm-confirm" href="{$addon.reinstall_url}">
                        {__("addon_developer.reinstall")}
                    </a></span>
                {/if}
                {if ($addon.refresh_url)}
                    <span><a class="cm-post" href="{$addon.refresh_url}">
                        {__("refresh")}
                    </a></span>
                {/if}
            {/if}
        </li>
    {/foreach}
    </div>
</div>
{/capture}

{dropdown
    content=$smarty.capture.addon_list
    class=""
    icon="icon-puzzle-piece icon-blue"
    no_caret=true
    text={__("addon_developer")}
}

</div>
