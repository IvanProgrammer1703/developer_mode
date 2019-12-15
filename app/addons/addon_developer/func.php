<?php

require_once('AddonHelper.php');

use AddonDeveloper\AddonHelper;

function fn_settings_variants_addons_addon_developer_favorite_addons()
{
    $addons = AddonHelper::getSettingsAddonList();

    return $addons;
}
