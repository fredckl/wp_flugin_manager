<?php
/**
 * Plugin Name: Meta Box Manager
 * Author: Frédéric KOLLER
 * Description: Meta Box manager
 * Version: 1.0
 * Date: 2018-12-11
 * Time: 15:27
 */
namespace FkMetabox;

use \FkMetabox\Utils\Dumper;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}


require __DIR__ . DS . 'Utils' . DS . 'Dumper.php';



class FkMetaboxManager
{
    private $id;
    private $title;
    private $post_type;
    private $_fields;

    static private $_postTypes = [];

    private $_clsForm = 'fk-metabox';

    static public function addPostType($id, $name, $singular_name, $public = true, $has_archive = true)
    {

        static::$_postTypes[] = compact('id', 'name', 'singular_name', 'public', 'has_archive');
    }

    static public function addCss($id, $src)
    {
    }

    static public function addJS()
    {

    }

    public function __construct ($id, $title, $post_type)
    {
        add_action( 'admin_init', [$this, 'registerPostType']);
        add_action('admin_init', [$this, 'create_meta_box']);
        add_action('save_post', [$this, 'save']);
        $this->id = $id;
        $this->title = $title;
        $this->post_type = $post_type;
    }

    public function registerPostType ()
    {
        foreach (static::$_postTypes as $postType) {

            register_post_type( $postType['id'],
                array(
                    'labels' => array(
                        'name' => $postType['name'],
                        'singular_name' => $postType['singular_name']
                    ),
                    'public' => $postType['public'],
                    'has_archive' => $postType['has_archive'],
                )
            );
        }
    }

    public function add ($id, $label, $input_type = 'text', $default = '')
    {
        $this->_fields[] = [
            'id' => $this->id . '_' . $id,
            'cls' => $id,
            'label' => $label,
            'type' => $input_type,
            'default' => $default
        ];

        return $this;
    }


    public function create_meta_box ()
    {
        if (function_exists('add_meta_box')) {
            add_meta_box($this->id, $this->title, [$this, 'render'],  $this->post_type);
        }
    }

    public function render ()
    {
        global $post;

        foreach ($this->_fields as $field) {
            extract($field);
            $value = get_post_meta($post->ID, $id, true);

            if ($value == '') {
                $value = $default;
            }
            $clsForm = sprintf('%s %s-%s', $this->_clsForm, $this->_clsForm, $cls);

            require __DIR__ . DS . $this->_createPaths(['views', 'admin', 'input' . '.php']);
        }

        if (!empty($this->_fields)) {
            echo '<input type="hidden" name="' . $this->id . '_nonce" value="'. wp_create_nonce($this->id) .'" />';
        }
    }

    private function _createPaths(array $paths)
    {
        return implode(DS, $paths);
    }


    /**
     * @param $post_id
     * @param $post
     * @param $update
     * @return bool
     */
    public function save ($post_id, $post, $update)
    {
        // Vérification de la capacité de pouvoir modifier un article
        if (!\current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        // Vérification du jeton de sécurité
        if (!\wp_verify_nonce($_POST[$this->id . '_nonce'], $this->id)) {
            return $post_id;
        }

        foreach ($this->_fields as $field) {
            $id = $field['id'];
            if (isset($_POST[$id])) {
                if (empty($_POST[$id])) {
                    \delete_post_meta($post_id, $id);
                } else {
                    if (\get_post_meta($post_id, $id)) {
                        \update_post_meta($post_id, $id, $_POST[$id]);
                    } else {
                        \add_post_meta($post_id, $id, $_POST[$id]);
                    }
                }
            }
        }
    }
}

//FkMetaboxManager::addCss(1,"zz");
FkMetaboxManager::addPostType('etalon', __('Etalons'), __('Etalon'), true, true);

$box = new FkMetaboxManager('fk_metabox', 'Information', 'etalon');
$box->add('price', 'Prix');
$box->add('race', 'Race');
$box->add('description', 'Description', 'textarea');
