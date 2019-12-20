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

namespace AddonDeveloper;

use Tygh\Registry;

class AddonHelper
{
    //TODO: Get addons from last edited addons
    // public static $favoriteAddons;
    static $setting_favorite_addons = 'addons.addon_developer.favorite_addons';

    public static function getAddonList($params = [], $exclude_favorites = false)
    {
        list($addons) = fn_get_addons($params);
        if ($exclude_favorites) {
            $favorite_addons = Registry::get(static::$setting_favorite_addons);
            $addons = array_diff_key($addons, $favorite_addons);
        }
        return $addons;
    }

    public static function reinstallAddon($addon_name)
    {
        return fn_uninstall_addon($addon_name)
        && fn_install_addon($addon_name);
    }

    public static function getFavoriteAddonList()
    {
        $favorite_addons = Registry::get(static::$setting_favorite_addons);
        $addons = [];
        if (!empty($favorite_addons)) {
            $addons = static::getAddonList();
        }
        $addons = array_intersect_key($addons, $favorite_addons);
        foreach ($addons as $addon_key => &$addon) {
            $addon['urls'] = static::generateAddonUrls($addon_key, $addon['status']);
        }

        return $addons;
    }

    public static function getSettingsAddonList()
    {
        $addons = static::getAddonList();
        $addons = array_map(function($addon) {return $addon['name'];}, $addons);

        return $addons;
    }

    public static function generateAddonUrls($addon_key, $status = '', $current_url = '')
    {
        if (!$current_url) {
            $current_url = Registry::get('config.current_url');
        }
        $return_url = urlencode($current_url);

        if ($status == 'N') {
            $actions = [
                'install' => 'install'
            ];
        }
        else {
            $actions = [
                'refresh' => 'refresh',
                'reinstall' => 'reinstall',
                'update' => 'update',
                'uninstall' => 'uninstall'
            ];
        }

        $urls = [];
        foreach ($actions as $action_key => $action) {
            $urls[$action_key] = fn_url("addons.{$action}&addon={$addon_key}") . "&return_url={$return_url}";
        }

        if ($status == 'A') {
            $urls['disable'] = fn_url("addons.update_status&status=D&id={$addon_key}") . "&redirect_url={$return_url}";
        } elseif ($status == 'D') {
            $urls['enable'] = fn_url("addons.update_status&status=A&id={$addon_key}") . "&redirect_url={$return_url}";
        }

        return $urls;
    }
}
