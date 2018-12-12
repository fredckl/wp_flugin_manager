<?php
/**
 * Plugin Name: Meta Box Manager
 * Author: Frédéric KOLLER
 * Description: Meta Box manager
 * Version: 1.0
 * Date: 2018-12-11
 * Time: 15:27
 */


if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}


require_once __DIR__ . DS . 'Utils' . DS . 'Dumper.php';
require_once __DIR__ . DS . 'FkMetaboxManager.php';


//FkMetaboxManager::addCss('my-css', \plugins_url('js/admin/test.css', __FILE__));
FkMetaboxManager::addJS('jsUploader', \plugins_url('js/admin/uploader.js', __FILE__));
FkMetaboxManager::addPostType('etalon', __('Etalons'), __('Etalon'), true, true);

$box = new FkMetaboxManager('fk_metabox', 'Information', 'etalon');
$box->add('price', 'Prix');
$box->add('race', 'Race');
$box->add('description', 'Description', 'textarea');
$box->add('autre', 'Autre', 'wysiwyg');
$box->add('image', 'Image', 'upload');
