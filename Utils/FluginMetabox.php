<?php
/**
 * Created by PhpStorm.
 * User: frederickoller
 * Date: 2018-12-12
 * Time: 07:11
 */

class FluginMetabox
{
    /**
     * @var string Indetifiant de la boxe
     */
    private $id;

    /**
     * @var string Titre de la boxe
     */
    private $title;

    /**
     * @var strign Applicable pour un type de poste uniquement
     */
    private $post_type;

    /**
     * @var array Champs de meta post
     */
    private $_fields;

    /**
     * @var string Classe englobant les inputs
     */
    private $_prefix;

    private $_defaultInputParams = [
        'id' => null,
        'label' => '',
        'default' => '',
        'options' => [
//            'containerVars' => [],
//            'labelVars' => [],
//            'inputVars' => []
        ]
    ];

    public function __construct ($id, $title, $post_type, $prefix = 'flugin-metabox')
    {
        add_action('admin_init', [$this, 'create_meta_box']);
        add_action('save_post', [$this, 'save']);
        $this->id = $id;
        $this->title = $title;
        $this->post_type = $post_type;
        $this->_prefix = $prefix;

        $this->_defaultInputParams['prefix'] = $prefix;
    }

    /**
     * Create a new input field
     * - id Identifier
     * - label Label
     * - default Default value
     * - options Other parameters
     * @param array $params
     * @return $this
     */
    public function add (array $params, array $options = [])
    {
        $containerVars = $labelVars = $inputVars = ['class' => null];

        $containerVars['class'] = sprintf('%s input-%s %s-%s', $this->_prefix, $params['type'], $this->_prefix, $params['type']);
        if (isset($options['containerVars']) && is_array($options['containerVars'])) {
            $containerVars = $this->setAttributes($containerVars, $options['containerVars']);
        }
        $containerVars = flugin_convert_to_attrs(array_filter($containerVars));

        if (isset($options['labelVars']) && is_array($options['labelVars'])) {
            unset($labelVars['for']);
            $labelVars = $this->setAttributes($labelVars, $options['labelVars']);
        }
        $labelVars = flugin_convert_to_attrs(array_filter($labelVars));

        if (isset($options['inputVars']) && is_array($options['inputVars'])) {
            unset($inputVars['id']);
            unset($inputVars['data-id']); // Mot reservé

            $inputVars = $this->setAttributes($inputVars, $options['labelVars']);
        }
        $inputVars = flugin_convert_to_attrs(array_filter($inputVars));

        $params += $this->_defaultInputParams;
        $params['id'] = flugin_slugify($this->_prefix . '-' . $params['id'], '_');
        $params['options'] = compact('containerVars', 'labelVars', 'inputVars');

        $this->_fields[] = $params;

        return $this;
    }

    /**
     * @param array $form
     * @param array $to
     * @return array
     */
    public function setAttributes(array $form, array $to)
    {
        foreach ($to as $key => $val) {
            $form[$key] = isset($form[$key]) ? $form[$key] . ' ' . $val : $val;
        }

        return $form;
    }

    /**
     * @param integer $id Identifiant
     * @param string $label Label du champ
     * @param string $default
     * @param null $cls
     * @return $this
     */
    public function addTextField($id, $label, $default = '', array $options = [])
    {
        $params = compact('id', 'label', 'default');
        $params['type'] = 'text';
        $this->add($params, $options);
        return $this;
    }

    public function addTextareaField($id, $label, $default = '', array $options = [])
    {
        $params = compact('id', 'label', 'default');
        $params['type'] = 'textarea';
        $this->add($params, $options);
        return $this;
    }

    public function addWysiWygField ($id, $label, $default = '', array $options = [])
    {
        $params = compact('id', 'label', 'default');
        $params['type'] = 'wysiwyg';
        $this->add($params, $options);
        return $this;
    }

    public function addUploadField($id, $label, $multiple = false, $default = '', array $options = [])
    {
        $params = compact('id', 'label', 'multiple', 'default');
        $params['type'] = 'upload';
        $this->add($params, $options);
        return $this;
    }

    /**
     * Alias To AddUploadField
     * @param $id
     * @param $label
     * @param string $default
     * @param array $options
     * @return $this
     */
    public function addUploaderField($id, $label, $default = '', array $options = [])
    {
        $this->addUploadField($id, $label, $default = '',  $options);
        return $this;
    }

    /**
     * @param $id
     * @param $label
     * @param array $selects
     * @param null $empty Empty value
     * @param null $default
     * @param array $options
     * @return $this
     */
    public function addSelectField($id, $label, array $selects, $empty = null, $default = null, array $options = [])
    {
        $params = compact('id', 'label', 'selects', 'empty', 'default');
        $params['type'] = 'select';
        $this->add($params, $options);
        return $this;
    }

    public function addRadioField($id, $label, array $radios, $default = null, array $options = [])
    {
        $params = compact('id', 'label', 'radios', 'default');
        $params['type'] = 'radio';
        $this->add($params, $options);
        return $this;
    }

    public function addCheckboxField($id, $label, array $checkboxs, $default = null, array $options = [])
    {
        if (is_string($default)) {
            $default = [$default];
        }

        $params = compact('id', 'label', 'checkboxs', 'default');
        $params['type'] = 'checkbox';
        $this->add($params, $options);
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
            $value = get_post_meta($post->ID, $field['id'], true);

            if ($value == '') {
                $value = $field['default'];
            }

            extract($field);
//            var_dump($options['containerVars']);
//            var_dump(get_defined_vars());die;
            require FLUGIN_VIEW . flugin_create_path(['admin', 'input.php']);
        }

        if (!empty($this->_fields)) {
            echo '<input type="hidden" name="' . $this->id . '_nonce" value="'. wp_create_nonce($this->id) .'" />';
        }
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