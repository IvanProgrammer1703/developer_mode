<?php

use AddonDeveloper\AddonDev;

defined('BOOTSTRAP') or die('Access denied');

if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
    && !defined('AJAX_REQUEST') && $controller == 'addon_dev'
    || in_array($controller, ['addon_dev', 'addons', 'notifications_center'])
) {
    return [CONTROLLER_STATUS_OK];
}

Tygh::$app['view']->assign([
    'addon_developer_settings_url' => AddonDev::generateAddonUrls('addon_developer', 'A', true)['update'],
    'addon_list' => AddonDev::getAddonList([], true),
    'favorite_addons' => AddonDev::getFavoriteAddonList(),
    'show_addon_developer_menu' => true
]);
