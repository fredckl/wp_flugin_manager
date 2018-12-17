<?php
/**
 * Created by PhpStorm.
 * User: frederic
 * Date: 2018-12-17
 * Time: 17:11
 */

require_once __DIR__ . DS . flugin_create_path(['Utils', 'Dumper.php']);
require_once __DIR__ . DS . flugin_create_path(['Utils', 'FluginAssets.php']);
require_once __DIR__ . DS . flugin_create_path(['Utils', 'FluginMetabox.php']);
require_once __DIR__ . DS . flugin_create_path(['Utils', 'FluginPostType.php']);


$fluginAssets = new FluginAssets('admin_init');
$fluginAssets->addCss('fk-metabox', \plugins_url('css/admin/flugin-metabox.css', __FILE__));
$fluginAssets->addScript('fk-jsUploader', \plugins_url('js/admin/flugin-uploader.js', __FILE__));


$fluginPostType = new FluginPostType();
$fluginPostType->addPostType('etalon', __('Etalons'), __('Etalon'), true, true);


$box = new FluginMetabox('fk_metabox', 'Information', 'page');
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

$box->addSelectField('select_field', 'Faites votre choix', ['1' => "HAHAHA", 2 => 'YOUHOYOY'], 'choisissez', '1');
$box->addRadioField('select_radio', 'Faites votre choix', ['1' => "HAHAHA", 2 => 'YOUHOYOY'], '1');
$box->addCheckboxField('select_checkbox', 'Faites votre choix', ['1' => "HAHAHA", 2 => 'YOUHOYOY'], '1');


/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
    add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}

/** Step 3. */
function my_plugin_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    echo '<div class="wrap">';
    echo '<p>Here is where the form would go if I actually had options.</p>';
    echo '</div>';
}