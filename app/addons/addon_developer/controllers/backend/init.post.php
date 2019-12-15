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

use AddonDeveloper\AddonHelper;

defined('BOOTSTRAP') or die('Access denied');

if (!defined('AJAX_REQUEST')) {
    require_once(dirname(__DIR__, 2) . '/AddonHelper.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return [CONTROLLER_STATUS_OK];
    }

    $addons = AddonHelper::getAddonList([], true);
    $favorite_addons = AddonHelper::getFavoriteAddonList();

    Tygh::$app['view']->assign([
        'addon_list' => $addons,
        'favorite_addons' => $favorite_addons,
    ]);
}
