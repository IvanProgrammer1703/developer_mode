<div>

{capture "addon_list"}
    {foreach $addon_list as $addon}
        <li>
            {__("{$addon.addon}")}
            <a class="cm-post" href="{$addon.refresh_url}">{__("refresh")}</a>
            <a class="cm-post cm-confirm" href="{$addon.reinstall_url}">{__("addon_developer.reinstall")}</a>
        </li>
    {/foreach}
{/capture}

{dropdown
    content=$smarty.capture.addon_list
    class=""
    icon="icon-puzzle-piece icon-blue"
    no_caret=true
    text={__("addon_developer")}
}

</div>
