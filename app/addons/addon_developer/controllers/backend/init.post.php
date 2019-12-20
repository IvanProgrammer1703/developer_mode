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

if ($_SERVER['REQUEST_METHOD'] == 'POST'
    || in_array($controller, [
            'addons',
            'addon_dev',
            'notifications_center',
        ])
    || defined('AJAX_REQUEST') && $controller != 'index'
) {
    return [CONTROLLER_STATUS_OK];
}

$addons = AddonDev::getAddonList([], true);
$favorite_addons = AddonDev::getFavoriteAddonList();

Tygh::$app['view']->assign([
    'addon_list' => $addons,
    'favorite_addons' => $favorite_addons,
    'show_addon_developer_menu' => true
]);
