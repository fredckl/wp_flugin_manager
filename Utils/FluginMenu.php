<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-13
 * Time: 17:19
 */

class FluginMenu
{
    private $_menus = [];


    public function __construct ($action = 'admin_menu')
    {
        add_action($action, [$this, 'loadMenus']);
    }

    /**
     * @return array
     */
    public function loadMenus ()
    {
        foreach ($this->_menus as $menuTypes) {
            if (is_array($menuTypes)) {
                foreach ($menuTypes as $key => $menuType) {
                    if ($key === 'main') {
                        \add_menu_page( $menuType['parent_slug'], $menuType['page_title'], $menuType['capability'], $menuType['menu_slug'], $menuType['function'], $menuType['icon_url'], $menuType['position']);
                    } else {
                        \add_submenu_page( $menuType['parent_slug'], $menuType['page_title'], $menuType['menu_title'], $menuType['capability'], $menuType['menu_slug'], $menuType['function']);
                    }
                }
            }
        }
    }

    public function addMenuPage($page_title, $menu_title, $capability = 'edit_post', $menu_slug, $function, $icon_url, $position)
    {
        $this->_menus['main'][] = compact('page_title', 'menu_title', 'capability', 'menu_slug', 'function', 'icon_url', 'position');
    }

    public function addSubMenu($parent_slug, $page_title, $menu_title, $capability = 'edit_post', $menu_slug, $function)
    {
        $this->_menus['sub'][] = compact('parent_slug', 'page_title', 'menu_title', 'capability', 'menu_slug', 'function');
    }
}