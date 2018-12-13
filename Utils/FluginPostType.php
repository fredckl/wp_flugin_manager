<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-13
 * Time: 15:46
 */

class FluginPostType
{
    /**
     * @var array Type de champs autorisé
     */
    private $_postTypes = [];

    public function __construct ($action = 'admin_init')
    {
        add_action($action, [$this, 'registerPostType']);
    }

    public function addPostType($id, $name, $singular_name, $public = true, $has_archive = true)
    {
        $this->_postTypes[] = compact('id', 'name', 'singular_name', 'public', 'has_archive');
    }

    public function registerPostType ()
    {
        foreach ($this->_postTypes as $postType) {
            \register_post_type( $postType['id'],
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
}