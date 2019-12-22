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

use Tygh\Tygh;
use Tygh\Enum\YesNo;
use Tygh\Registry;
use Tygh\Settings;
use Tygh\Addons\SchemesManager;
use Tygh\Enum\NotificationSeverity;

class AddonDev
{
    //TODO: Get addons from last edited addons
    // public static $favoriteAddons;
    static $setting_favorite_addons = 'addons.addon_developer.favorite_addons';

    public static function getAddonList($params = [], $exclude_favorites = false, $generate_urls = false)
    {
        list($addons) = fn_get_addons($params);
        if ($exclude_favorites) {
            $favorite_addons = Registry::get(static::$setting_favorite_addons);
            if (is_array($favorite_addons)) {
                $addons = array_diff_key($addons, $favorite_addons);
            }
        }
        unset($addons['addon_developer']);

        foreach ($addons as $addon_id => &$addon) {
            if (empty($addon['addon'])) {
                if (!is_array($addon)) {
                    $addon = [];
                }
                $addon['addon'] = $addon_id;
            }
        }

        if ($generate_urls) {
            foreach ($addons as $addon_id => &$addon) {
                $addon['urls'] = static::generateAddonUrls($addon_id, $addon['status'], $addon['has_options']);
            }
        }
        return $addons;
    }

    public static function getAddon($addon_id, $generate_urls = true, $return_url = '')
    {
        list($addons) = fn_get_addons([]);
        $addon = $addons[$addon_id];
        if ($generate_urls) {
            $addon['urls'] = static::generateAddonUrls($addon_id, $addon['status'], $addon['has_options'], $return_url);
        }
        if ($addon && empty($addon['addon'])) {
            $addon['addon'] = $addon_id;
        }

        return $addon;
    }

    public static function installAddon($addon_id, $result_ids, $return_url)
    {
        if (fn_install_addon($addon_id)) {
            $addon = static::getAddon($addon_id, true, $return_url);

            Tygh::$app['view']->assign([
                'addon' => $addon,
                'ajax_append' => true
            ]);

            $html = [
                'installed' => true,
                $result_ids => Tygh::$app['view']->fetch('addons/addon_developer/views/addon_developer/components/favorite_addon.tpl')
            ];

            Tygh::$app['ajax']->assign('html', $html);
        }
    }

    public static function uninstallAddon($addon_id, $result_ids)
    {
        if (fn_uninstall_addon($addon_id)) {
            $addon = static::getAddon($addon_id, true);

            Tygh::$app['view']->assign([
                'addon' => $addon,
                'ajax_append' => true
            ]);

            $html = [
                'uninstalled' => true,
                $result_ids => Tygh::$app['view']->fetch('addons/addon_developer/views/addon_developer/components/favorite_addon.tpl')
            ];

            Tygh::$app['ajax']->assign('html', $html);
        }
    }

    public static function reinstallAddon($addon_id)
    {
        return fn_uninstall_addon($addon_id)
        && fn_install_addon($addon_id);
    }

    public static function refreshAddon($addon_id)
    {
        $addon_scheme = SchemesManager::getScheme($addon_id);

        fn_update_addon_language_variables($addon_scheme);

        $settings_values = fn_get_addon_settings_values($addon_id);
        $settings_vendor_values = fn_get_addon_settings_vendor_values($addon_id);

        $update_addon_settings_result = fn_update_addon_settings($addon_scheme, true, $settings_values, $settings_vendor_values);

        fn_clear_cache();
        Registry::clearCachedKeyValues();

        if ($update_addon_settings_result) {
            fn_set_notification(
                NotificationSeverity::NOTICE,
                __('notice'),
                __('text_addon_refreshed', ['[addon]' => $addon_id])
            );
        }
    }

    public static function toggleAddon($addon_id, $new_state)
    {
        $is_snapshot_correct = fn_check_addon_snapshot($addon_id);
        if (!$is_snapshot_correct) {
            $state_changed = false;
        } else {
            $state_changed = true === fn_update_addon_status($addon_id, $new_state ? 'A' : 'D');
        }
        if ($state_changed) {
            Registry::clearCachedKeyValues();
        }

        Tygh::$app['ajax']->assign('state_changed', $state_changed);
    }

    public static function addToFavorites($addon_id, $return_url)
    {
        $favorite_addons = Settings::instance()->getValue('favorite_addons', 'addon_developer');

        $addon = null;

        // check if addon already in list
        if (!in_array($addon_id, array_keys($favorite_addons))) {
            $favorite_addons[$addon_id] = YesNo::YES;
            Settings::instance()->updateValue('favorite_addons', array_keys($favorite_addons), 'addon_developer');
            $addon_info = static::getAddon($addon_id);
            $addon = [
                'addon' => $addon_id,
                'name' => $addon_info['name'],
                'status' => $addon_info['status'],
                'urls' => static::generateAddonUrls($addon_id, $addon_info['status'], $addon_info['has_options'], $return_url)
            ];
        }
        if ($addon) {
            Tygh::$app['view']->assign([
                'addon' => $addon,
                'addon_id' => $addon_id
            ]);

            Tygh::$app['ajax']->assign('response', Tygh::$app['view']->fetch('addons/addon_developer/views/addon_developer/components/favorite_addon.tpl'));
        }
    }

    public static function removeFromFavorites($addon_id)
    {
        $favorite_addons = Settings::instance()->getValue('favorite_addons', 'addon_developer');
        $is_removed = false;

        if (in_array($addon_id, array_keys($favorite_addons))) {
            unset($favorite_addons[$addon_id]);
            Settings::instance()->updateValue('favorite_addons', array_keys($favorite_addons), 'addon_developer');
            $is_removed = true;
            fn_set_notification(
                NotificationSeverity::NOTICE,
                __('notice'),
                __('addon_developer.addon_removed_from_favorites', ['[addon]' => $addon_id])
            );
        }

        Tygh::$app['ajax']->assign('is_addon_removed', $is_removed);
    }

    public static function getFavoriteAddonList()
    {
        $favorite_addons = Registry::get(static::$setting_favorite_addons);

        $addons = [];
        if (!empty($favorite_addons)) {
            $addons = static::getAddonList();
        }
        if (is_array($favorite_addons)) {
            $addons = array_intersect_key($addons, $favorite_addons);
        }
        foreach ($addons as $addon_id => &$addon) {
            $addon['urls'] = static::generateAddonUrls($addon_id, $addon['status'], $addon['has_options'] ?? false);
        }

        return $addons;
    }

    public static function getSettingsAddonList()
    {
        $addons = static::getAddonList();
        $addons = array_map(function($addon) {return $addon['name'];}, $addons);

        return $addons;
    }

    /**
     * Generates urls for addon
     * @param string $addon_id addon id from addon.xml
     * @param string $status from fn_get_addons
     * @param string $has_options from fn_get_addons
     * @param string $return_url required for ajax, gets from JS window.location.href
     */
    public static function generateAddonUrls($addon_id, $status, $has_options = false, $return_url = '')
    {
        if (!$return_url) {
            $return_url = Registry::get('config.current_url');
        }
        $return_url = urlencode($return_url);

        if ($status == 'N') {
            $actions['install'] = 'install';
        } else {
            $actions = [
                'refresh' => 'refresh',
                'reinstall' => 'reinstall',
                'uninstall' => 'uninstall',
                'toggle' => 'toggle'
            ];
            if ($has_options) {
                $actions['update'] = 'update';
            }
        }
        $actions['remove_from_fav'] = 'remove_from_fav';

        $urls = [];
        foreach ($actions as $action_key => $action) {
            $urls[$action_key] = fn_url("addon_dev.{$action}&addon={$addon_id}") . "&return_url={$return_url}";
        }

        return $urls;
    }
}
