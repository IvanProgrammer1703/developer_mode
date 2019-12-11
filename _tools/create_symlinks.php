<?php
/**
 * The add-on creates symbolic links from current directory
 * To delete symbolic links, add "delete" to the end of the request
 */
if (empty($argv[1])) {
    echo 'You didn\'t specify the target directory, use: php create_symlinks.php ../../435 [ delete ]' . PHP_EOL;
    exit(127);
}

$addon_name = 'addon_developer';

$paths = array(
    '/app/addons/' . $addon_name => '/app/addons/' . $addon_name,
    '/design/backend/media/images/addons/' . $addon_name => '/design/backend/media/images/addons/' . $addon_name,
    '/design/backend/templates/addons/' . $addon_name => '/design/backend/templates/addons/' . $addon_name,
    '/design/backend/css/addons/' . $addon_name => '/design/backend/css/addons/' . $addon_name,
    '/js/addons/'. $addon_name => '/js/addons/'. $addon_name,
    '/design/themes/responsive/css/addons/' . $addon_name => '/var/themes_repository/responsive/css/addons/' . $addon_name,
    '/design/themes/responsive/templates/addons/' . $addon_name => '/var/themes_repository/responsive/templates/addons/' . $addon_name,
    '/var/langs/en/addons/' . $addon_name . '.po' => '/var/langs/en/addons/' . $addon_name . '.po',
    '/var/langs/ru/addons/' . $addon_name . '.po' => '/var/langs/ru/addons/' . $addon_name . '.po',
);


$dir_target = realpath($argv[1]);

$dir = realpath(dirname(__FILE__) . '/../');

foreach ($paths as $target => $source) {

    if (file_exists($dir_target . $target)) {
        unlink($dir_target . $target);
    }

    if (!isset($argv[2]) || $argv[2] != 'delete') {
          // WIN
        if (DIRECTORY_SEPARATOR == '\\') {
            $dirSrc = $dir . str_replace('/', '\\', $source);
            $dirDest = $dir_target . str_replace('/', '\\', $target);
            if (file_exists($dirSrc)) {
                exec('mklink /D ' . '"' . $dirDest . '"' . ' ' . '"' .  $dirSrc . '"' . ' ');
            } else {
                echo ('directory \'' . str_replace('/', '\\', $target) . "' not found. Skip. \r\n");
            }
        }
        // NIX
        else {
            if (file_exists($dir . $source)) {
                system("ln -s {$dir}{$source} {$dir_target}{$target}");
            } else {
                echo ('directory \'' . substr($source, 1) . "' not found. Skip. \r\n");
            }
        }
    }
}
