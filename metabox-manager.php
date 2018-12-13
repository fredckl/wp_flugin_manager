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
require_once __DIR__ . DS . 'functions.php';
require_once __DIR__ . DS . 'FkMetaboxManager.php';


FkMetaboxManager::addCss('fk-metabox', \plugins_url('css/admin/fk-metabox.css', __FILE__));
FkMetaboxManager::addJS('fk-jsUploader', \plugins_url('js/admin/uploader.js', __FILE__));

FkMetaboxManager::addPostType('etalon', __('Etalons'), __('Etalon'), true, true);

$box = new FkMetaboxManager('fk_metabox', 'Information', 'etalon');
$box->addTextField(
    'price',
    'Prix',
    null,
    [
        'containerVars' => ['id' => 'cool', 'class' => 'blablable'],
        'labelVars' => ['for' => '(frfr)', 'id' => 'label', 'class' => 'oooo'],
        'inputVars' => ['data-orange' => 'red', 'data-id' => '3']
    ]
);
$box->addTextareaField(
    'description',
    'Déscription',
    null,
    [
        'containerVars' => ['id' => 'description', 'class' => 'description'],
        'labelVars' => ['id' => 'rrrrrr']
    ]
);

$box->addWysiWygField('desc_long', 'Description longue', 'HAHHAHA');

$box->addUploadField('vignette', 'Vignette', true);
//$box->add('race', 'Race');
//$box->add('description', 'Description', 'textarea');
//$box->add('autre', 'Autre', 'wysiwyg');
//$box->add('image', 'Image', 'upload');
