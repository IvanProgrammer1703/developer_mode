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
    //TODO: Get addons from settings or last edited addons
    // public static $favoriteAddons;

    public static function getAddonList($params = [], $generate_urls = false)
    {
        list($addons) = fn_get_addons($params);
        if ($generate_urls) {
            $addons = static::generateAddonsUrls($addons);
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
        $setting = 'addons.addon_developer.favorite_addons';
        $favorite_addons = Registry::get($setting);
        $addons = [];
        if (!empty($favorite_addons)) {
            $addons = static::getAddonList();
        }
        $addons = array_intersect_key($addons, $favorite_addons);
        $addons = static::generateAddonsUrls($addons);

        return $addons;
    }

    public static function getSettingsAddonList()
    {
        $addons = static::getAddonList();
        $addons = array_map(function($addon) {return $addon['name'];}, $addons);

        return $addons;
    }

    public static function generateAddonsUrls($addons)
    {
        $current_url = Registry::get('config.current_url');

        $actions = [
            'refresh',
            'reinstall',
            'update',
            'install',
            'uninstall',
        ];
        foreach ($addons as $addon_key => &$addon) {
            foreach ($actions as $action) {
                $return_url = urlencode($current_url);
                $addon[$action . '_url'] = fn_url("addons.{$action}&addon={$addon_key}") . "&return_url={$return_url}";
            }
        }

        return $addons;
    }
}
