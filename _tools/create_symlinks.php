<?php
/**
 * The add-on creates symbolic links from current directory
 * To delete symbolic links, add "delete" to the end of the request
 */
if (empty($argv[1])) {
    echo 'You didn\'t specify the target directory, use: php create_symlinks.php ../../435 [ delete ]' . PHP_EOL;
    exit(127);
}

$paths = array(
    '/design/backend/css/addons/addon_developer' => '/design/backend/css/addons/addon_developer',
    '/app/addons/addon_developer' => '/app/addons/addon_developer',
    '/design/backend/templates/addons/addon_developer' => '/design/backend/templates/addons/addon_developer',
    '/design/backend/media/images/addons/addon_developer' => '/design/backend/media/images/addons/addon_developer',
    '/design/backend/mail/templates/addons/addon_developer' => '/design/backend/mail/templates/addons/addon_developer',
    '/var/langs/en/addons/addon_developer.po' => '/var/langs/en/addons/addon_developer.po',
    '/var/langs/ru/addons/addon_developer.po' => '/var/langs/ru/addons/addon_developer.po',
    '/js/addons/addon_developer' => '/js/addons/addon_developer',
    '/design/themes/responsive/templates/addons/addon_developer' => '/var/themes_repository/responsive/templates/addons/addon_developer',
    '/design/themes/responsive/mail/templates/addons/addon_developer' => '/var/themes_repository/responsive/mail/templates/addons/addon_developer',
    '/design/themes/responsive/css/addons/addon_developer' => '/var/themes_repository/responsive/css/addons/addon_developer',
);

$source_dir = realpath(dirname(__FILE__) . '/../');

$target_dir = realpath($argv[1]);

foreach ($paths as $target => $source) {

    $target = fn_fix_path($target);
    $source = fn_fix_path($source);

    if (file_exists($target_dir . $target)) {
        unlink($target_dir . $target);
    }
    if (!isset($argv[2]) || $argv[2] != 'delete') {

        $command = fn_fix_path("ln -s {$source_dir}{$source} {$target_dir}{$target}");

        system($command);
    }

}

function fn_fix_path($path)
{
    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}
