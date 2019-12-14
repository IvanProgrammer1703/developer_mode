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
use Tygh\Registry;

class AddonHelper
{
    //TODO: Get addons from settings or last edited addons
    public static $favoriteAddons =
    [
        'addon_developer',
        'banners',
        'seo'
    ];

    public static function getAddonList($params = [])
    {
        list($addons, $params, $addon_counter) = fn_get_addons($params);
        $current_url = urlencode(Registry::get('config.current_url'));

        foreach ($addons as $addon_key => &$addon) {
            if ($addon['status'] == 'N') {
                $addon['install_url'] = fn_url("addons.install?addon={$addon_key}&return_url={$current_url}");
            }
            else {
                $addon['reinstall_url'] = fn_url("addons.reinstall?addon={$addon_key}&return_url={$current_url}");
            }
        }

        return $addons;
    }

    public static function reinstallAddon($addon_name)
    {
        return fn_uninstall_addon($addon_name)
        && fn_install_addon($addon_name);
    }
}
