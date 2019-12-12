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

use Tygh\Registry;
use AddonDeveloper\AddonHelper;

require_once(dirname(__DIR__, 2) . '/AddonHelper.php');

defined('BOOTSTRAP') or die('Access denied');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'reinstall_addon') {
        if (!empty($_REQUEST['addon'])) {
            if (AddonHelper::reinstallAddon($_REQUEST['addon'])) {
                return [CONTROLLER_STATUS_OK];
            }
        }
    }
    // return [CONTROLLER_STATUS_NO_PAGE];
}
