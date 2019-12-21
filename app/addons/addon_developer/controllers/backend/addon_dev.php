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
use AddonDeveloper\AddonDev;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

if (!file_exists(dirname(__DIR__, 2) . '/AddonDev.php')) return;
require_once(dirname(__DIR__, 2) . '/AddonDev.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $addon_id = $_REQUEST['addon'] ?? $_REQUEST['addon_id'] ?? null;
    $return_url = $_REQUEST['return_url'] ?? 'addons.manage';

    if (!empty($addon_id)) {

        if ($mode == 'install') {
            if (AddonDev::installAddon($addon_id)) {

                return [CONTROLLER_STATUS_OK];
            }
        }

        if ($mode == 'uninstall') {
            if (AddonDev::uninstallAddon($addon_id)) {

                return [CONTROLLER_STATUS_OK];
            }
        }

        if ($mode == 'reinstall') {
            if (AddonDev::reinstallAddon($addon_id)) {

                return [CONTROLLER_STATUS_OK];
            }
        }

        if ($mode == 'refresh') {
            if (AddonDev::refreshAddon($addon_id)) {

                return [CONTROLLER_STATUS_OK];
            }
        }

        if ($mode == 'toggle') {
            $state = $_REQUEST['state'] ?? false;
            $state_changed = AddonDev::toggleAddon($addon_id, $state);
            Tygh::$app['ajax']->assign('state_changed', $state_changed);

            return [CONTROLLER_STATUS_OK];
        }

        if ($mode == 'add_to_fav') {
            list($addon_id, $addon) = AddonDev::addToFavorites($addon_id);

            if ($addon) {
                Tygh::$app['view']->assign('addon', $addon);
                Tygh::$app['view']->assign('addon_id', $addon_id);
                Tygh::$app['ajax']->assign('response', Tygh::$app['view']->fetch('addons/addon_developer/views/addon_developer/components/favorite_addon.tpl'));
                return [CONTROLLER_STATUS_OK];
            }
        }
    }

    return [CONTROLLER_STATUS_DENIED];
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

    foreach ($addon_list as $addon_key => &$addon) {
        $addon['urls'] = AddonDev::generateAddonUrls($addon_key, $addon['status']);
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
