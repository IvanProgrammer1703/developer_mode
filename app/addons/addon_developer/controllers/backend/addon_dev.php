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

use Tygh\Tygh;
use AddonDeveloper\AddonDev;

defined('BOOTSTRAP') or die('Access denied');

if (!file_exists(dirname(__DIR__, 2) . '/AddonDev.php')) return;
require_once(dirname(__DIR__, 2) . '/AddonDev.php');

if (defined('AJAX_REQUEST') && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $addon_id = $_REQUEST['addon'] ?? $_REQUEST['addon_id'] ?? null;
    $return_url = $_REQUEST['return_url'] ?? 'addons.manage';
    $result_ids = $_REQUEST['result_ids'] ?? '';
    if (!empty($addon_id)) {

        if ($mode == 'install') {
            AddonDev::installAddon($addon_id, $result_ids, $return_url);
        }

        if ($mode == 'uninstall') {
            AddonDev::uninstallAddon($addon_id, $result_ids);
        }

        if ($mode == 'reinstall') {
            AddonDev::reinstallAddon($addon_id);
        }

        if ($mode == 'refresh') {
            AddonDev::refreshAddon($addon_id);
        }

        if ($mode == 'toggle') {
            $state = $_REQUEST['state'] ?? false;
            AddonDev::toggleAddon($addon_id, $state);
        }

        if ($mode == 'add_to_fav') {
            AddonDev::addToFavorites($addon_id, $return_url);
        }

        if ($mode == 'remove_from_fav') {
            AddonDev::removeFromFavorites($addon_id);
        }
    }
    exit;
}

if ($mode == 'update') {
    fn_dispatch('addons', 'update');
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
        'dispatch' => 'addon_dev.get_addon_list'
    ];
    $params = array_merge($default_params, $params);
    $addon_list = AddonDev::getAddonList($params, true);

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
