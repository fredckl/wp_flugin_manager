<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-13
 * Time: 15:10
 */

class FluginAssets
{
    private $is_started= false;
    /**
     * @var array Fichier JS à charger
     */
    private $_scriptFiles = [];

    /**
     * @var array Fichier CSS à charger
     */
    private $_cssFiles = [];

    public function __construct ($start = true)
    {
        if ($start) {
            $this->is_started = true;
            add_action('admin_enqueue_scripts', [$this, '_loadAll']);
        }
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param bool $ver
     * @param string $media
     */
    public function addCss($handle, $src, $deps = array(), $ver = false, $media = 'all')
    {
        $this->_cssFiles[] = compact('handle', 'src', 'deps', 'ver', 'media');
        return $this;
    }

    /**
     * @param string $handle
     * @param string $src
     * @param array $deps
     * @param bool $ver
     * @param bool $in_footer
     */
    public function addScript($handle, $src, $deps = array(), $ver = false, $in_footer = false)
    {
        $this->_scriptFiles[] = compact('handle', 'src', 'deps', 'ver', 'in_footer');
        return $this;
    }

    public function _loadAll()
    {
        $this->_loadScripts();
        $this->_loadStyles();
    }

    public function loadScripts ()
    {
        if (!$this->is_started) {
            add_action('admin_enqueue_scripts', [$this, '_loadScripts']);
        }
    }

    public function loadStyles ()
    {
        if (!$this->is_started) {
            add_action('admin_enqueue_scripts', [$this, '_loadStyles']);
        }
    }

    /**
     * Load scripts
     */
    public function _loadScripts()
    {
        foreach ($this->_scriptFiles as $scriptFile) {
            \wp_register_script(
                $scriptFile['handle'],
                $scriptFile['src'],
                $scriptFile['deps'],
                $scriptFile['ver'],
                $scriptFile['in_footer']);
            \wp_enqueue_script($scriptFile['handle']);
        }
    }

    /**
     * Load Styles
     */
    public function _loadStyles()
    {
        foreach ($this->_cssFiles as $cssFile) {
            \wp_register_style(
                $cssFile['handle'],
                $cssFile['src'],
                $cssFile['deps'],
                $cssFile['ver'],
                $cssFile['media']);
            \wp_enqueue_style($cssFile['handle']);
        }
    }

}