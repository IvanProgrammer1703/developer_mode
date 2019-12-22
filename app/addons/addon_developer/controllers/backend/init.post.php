<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

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
