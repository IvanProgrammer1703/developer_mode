<?php

require_once('AddonDev.php');

use AddonDeveloper\AddonDev;

function fn_settings_variants_addons_addon_developer_favorite_addons()
{
    $addons = AddonDev::getSettingsAddonList();

    return $addons;
}
