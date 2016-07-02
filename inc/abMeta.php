<?php
if (!class_exists('aBMetaClass')) {
    class aBMetaClass
    {
        /**
     * Holds the values to be used in the fields callbacks.
     */
    private $metaBoxesArr;
    // private $options;
    /**
     * Start up.
     */
    public function __construct($metaboxesArr)
    {
        if (isset($metaboxesArr)) {
            $metaboxesArr = $this->processArray($metaboxesArr);
            $this->gametaboxesArr = $metaboxesArr;
        }
        if (isset($metaboxesArr)) {
            //generate all the metaboxes
            add_action('add_meta_boxes', array($this, 'abAddMetaBox'));
            //save the metabox data
            add_action('save_post', array($this, 'save_metaBox_fields'), 10, 2);
        }
    }

        private function processArray($data)
        {
            //
        // Declaring a brand new array outside the loop
        //
        $newArr = array();
            foreach ($data->menus as $key => $value) {
                // $aBGeneral->showArr($value);
            foreach ($value->children as $key2 => $value2) {
                //set the type from array
                $type = $value->type;
                // initialize temporary fields
                $tempFields = array();
                // Loop Fields
                foreach ($value2->fields as $tFKey => $tFValue) {
                    $tFValue = (array) $tFValue;
                    $tempFields[] = $tFValue;
                }
                $context = '';
                $priority = '';
                if (isset($value2->context)) {
                    $context = $value2->context;
                }
                if (isset($value2->priority)) {
                    $priority = $value2->priority;
                }
                //new metabox added to array
                $newArr[] = array(
                    'name' => $value2->name,
                    'label' => $value2->label,
                    'type' => $type,
                    'cpt_name' => $value->name,
                    'callbackArgs' => array('fields'),
                    'fields' => $tempFields,
                    'context' => $context,
                    'priority' => $priority,
                );
            }
            }

            return $newArr;
        }

        public function abAddMetaBox()
        {
            $metaArr = $this->gametaboxesArr;
        // $aBGeneral = new GeneralFunctionality();
        // $aBGeneral->showArr($metaArr);

        $id = 'aB_';
            $title = 'Default Title';
            $callback = array($this, 'meta_callback_function');
            $context = 'advanced';
            $priority = 'default';
            $callback_args = null;
            if (!empty($metaArr)) {
                foreach ($metaArr as $count => $box) {
                    $type = $box['type'] ? $box['type'] : 'post';
                    $cpt_name = 'post';
                    if ($type === 'cpt' && isset($box['cpt_name'])) {
                        $cpt_name = $box['cpt_name'];
                    } else {
                        $cpt_name = $box['type'];
                    }
                    $context = $box['context'] ? $box['context'] : $context;
                    $priority = $box['priority'] ? $box['priority'] : $priority;
                    $id .= $count;
                    if (isset($box['label'])) {
                        $title = $box['label'] ? $box['label'] : $title;
                    }
                    if (isset($box['priority'])) {
                        $priority = $box['priority'] ? $box['priority'] : 'default';
                    }

                    $callback_args = $box['callbackArgs'] ? array('name' => $box['name'], 'fields' => $box['fields']) : null;
                    add_meta_box($id, $title, array($this, 'meta_callback_function'), $cpt_name, $context, $priority, $callback_args);
                }
            }
        }

    // save meta callback function on post (post/page/cpt) admin page submit/
    public function save_metaBox_fields($post_id, $post)
    {
        $metaArr = $this->gametaboxesArr;
        foreach ($metaArr as $mboxKey => $mboxValue) {
            switch ($mboxValue['type']) {
              //save meta if post, page, cpt
            case 'post':
            case 'page':
            case 'cpt':
            /* Verify the nonce before proceeding. */
            if (!isset($_POST['aB_nounce_'.$mboxValue['name']]) || !wp_verify_nonce($_POST['aB_nounce_'.$mboxValue['name']], basename(__FILE__))) {
                return $post_id;
            }

            /* Get the post type object. */
            $post_type = get_post_type_object($post->post_type);
            /* Check if the current user has permission to edit the post. */
            if (!current_user_can($post_type->cap->edit_post, $post_id)) {
                return $post_id;
            }
            foreach ($mboxValue['fields'] as $key => $field) {

                //field name
                $fieldName = 'abMB_'.$mboxValue['name'].$field['name'];

                // set the new value to a variable
                $new_meta_value = (isset($_POST[$fieldName]) ? $_POST[$fieldName] : '');
                // $this->showArr($value);
                # code...
                /* Get the meta key. */
                $meta_key = $fieldName;

                /* Get the meta value of the custom field key. */
                $meta_value = get_post_meta($post_id, $meta_key, true);

                /* If a new meta value was added and there was no previous value, add it. */
                if ($new_meta_value != '' && '' == $meta_value) {
                    add_post_meta($post_id, $meta_key, $new_meta_value);
                } /* If the new meta value does not match the old value, update it. */
                elseif ($new_meta_value !== $meta_value) {
                    update_post_meta($post_id, $meta_key, $new_meta_value);
                } /* If there is no new meta value but an old value exists, delete it. */
                elseif ('' == $new_meta_value && $meta_value) {
                    delete_post_meta($post_id, $meta_key, $meta_value);
                }
            }
        break;
        //don't try to save meta if anything else
        default:
          continue;
        break;
      }
        }
    }

        public function meta_callback_function($post, $args)
        {
            ?>
        <div class="container-fluid aBMB">
            <?php wp_nonce_field(basename(__FILE__), 'aB_nounce_'.$args['args']['name']);
            foreach ($args['args']['fields'] as $field => $val) {
                $this->generate_field($val, $args['args'], $post);
            }
            ?>
        </div>
        <?php

        }

        private function generate_field($field, $metabox, $post)
        {
            $fieldsC = new fieldsC();
            $args = array($field, $metabox, $post);
            $fieldsC->addMeta_field($args);
        }

        private function add_meta_fields($fieldsArr)
        {
        }
    }
}
