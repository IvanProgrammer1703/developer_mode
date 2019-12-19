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

use Tygh\Settings;
use Tygh\Enum\YesNo;
use AddonDeveloper\AddonHelper;

require_once(dirname(__DIR__, 2) . '/AddonHelper.php');

defined('BOOTSTRAP') or die('Access denied');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'reinstall') {
        if (!empty($_REQUEST['addon'])) {
            if (AddonHelper::reinstallAddon($_REQUEST['addon'])) {
                return [CONTROLLER_STATUS_OK];
            }
        }
    }
    if ($mode == 'add_to_fav') {
        $params = $_REQUEST;
        $addon_name = $params['addon_name'] ?? null;
        $result = [];
        if ($addon_name) {
            $setting = 'addons.addon_developer.favorite_addons';
            $favorite_addons = Settings::instance()->getValue('favorite_addons', 'addon_developer');
            if (!in_array($addon_name, $favorite_addons)) {
                $favorite_addons[$addon_name] = YesNo::YES;
                Settings::instance()->updateValue('favorite_addons', array_keys($favorite_addons), 'addon_developer');
                $favorite_addons = Settings::instance()->getValue('favorite_addons', 'addon_developer');
                $addon = [
                    'addon_name' => $addon_name,
                    'urls' => AddonHelper::generateAddonUrls($addon_name)
                ];
                $result = ['addon' => $addon];
            }

        }
        return json_encode($result);
    }

    // return [CONTROLLER_STATUS_NO_PAGE];
}

if ($mode == 'get_addon_list') {
    // $page_number = $_REQUEST['page'] ?? 1;
    // $page_size = $_REQUEST['page_size'] ?? Registry::get('settings.Appearance.elements_per_page');

    $params = [];
    if (!empty($_REQUEST['q'])) {
        $params['q'] = $_REQUEST['q'];
    }
    $default_params = [
        'type' => 'any',
        'source' => '',
        'dispatch' => 'addons.get_addon_list'
    ];
    $params = array_merge($default_params, $params);
    $addon_list = AddonHelper::getAddonList($params);
    foreach ($addon_list as $addon_key => &$addon) {
        $addon['urls'] = AddonHelper::generateAddonUrls($addon_key);
    }
    $objects = [];
    if ($addon_list) {
        $objects = array_values(array_map(function ($addon_list_keys, $addon_list) {
            // TODO: watch next todo
            // Tygh::$app['view']->assign('addon', $addon_list);
            return [
                'id' => $addon_list_keys,
                'text' => $addon_list['name'],
                // TODO: Is it possible to add buttons to select2 list?
                // 'data' => [
                    // 'content' => Tygh::$app['view']->fetch('addons/addon_developer/views/addon_developer/components/dropdown_elem.tpl')
                // ]
            ];
        }, array_keys($addon_list), $addon_list));
    }
    // Tygh::$app['ajax']->assign('addon_list', $addon_list);
    Tygh::$app['ajax']->assign('objects', $objects);
    Tygh::$app['ajax']->assign('total_objects', $params['total_items'] ?? count($objects));

    exit;
}
