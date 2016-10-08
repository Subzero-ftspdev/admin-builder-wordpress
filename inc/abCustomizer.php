<?php
if (!class_exists('aBCustomizerClass')) {
    class aBCustomizerClass
    {
        /**
     * Holds the values to be used in the fields callbacks.
     */
    private $CustomizerArr;
    // private $options;
    /**
     * Start up.
     */
    public function __construct($CustomizerArr)
    {
        if (isset($CustomizerArr)) {
            $CustomizerArr = $this->processArray($CustomizerArr);
            $this->CustomizerArr = $CustomizerArr;
        }
        if (isset($CustomizerArr)) {
            // customizer register
            add_action('customize_register', array($this, 'abCustomizeRegister'));
            //save the metabox data
            add_action('save_post', array($this, 'save_metaBox_fields'), 10, 2);
        }
    }

        private function processArray($data)
        {
            global $abGen;
            //
        // Declaring a brand new array outside the loop
        //
        $newArr = array();
            foreach ($data->menus as $key => $value) {
                // $aBGeneral->showArr($value);
            foreach ($value->children as $key2 => $value2) {
                //set the type from array
                $type = $value->type;
                if ($type !== 'customizer') {
                    continue;
                }
                // $abGen->showArr($value2);
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
                    'fields' => $tempFields,
                );
            }
            }

            return $newArr;
        }

        public function abCustomizeRegister($wp_customize)
        {
            $metaArr = $this->CustomizerArr;
            $aBGeneral = new GeneralFunctionality();

            $id = 'aB_';
            $title = 'Default Title';
            if (!empty($metaArr)) {
                foreach ($metaArr as $count => $box) {
                    $panelName = $box['name'] ? $box['name'] : 'No Name';

                    $type = $box['type'] ? $box['type'] : 'customizer';
                    if ($type !== 'customizer') {
                        exit;
                    }

                    //$metaArr[0]['fields']

                    $id = $panelName.$count;

                    $wp_customize->add_section('sectionID'.$id, array(
                      'title' => __($panelName, 'default'),
                      'priority' => 30,
                    ));

                    foreach ($metaArr[0]['fields'] as $panel) {
                        // $aBGeneral->showArr($panel);
                      $fieldName = $panel['name'] ? $panel['name'] : 'No Name';
                        $fieldType = $panel['type'] ? $panel['type'] : 'text';
                        $fieldLabel = $panel['label'] ? $panel['label'] : 'No Label';

                        //setting
                        $wp_customize->add_setting($fieldName.$id, array(
                          'default' => '',
                          'transport' => 'refresh',
                        ));

                      // Control field:
                      $wp_customize->add_control(new WP_Customize_Control($wp_customize, $fieldName,
                      array('label' => __($fieldLabel, 'default'),
                        'section' => 'sectionID'.$id,
                        'settings' => $fieldName.$id,
                      )));
                    }
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
                    continue;
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
                      $new_meta_value = (isset($_POST[$fieldName]) ? $_POST[$fieldName] : '0');
                      # code...
                      /* Get the meta key. */
                      $meta_key = $fieldName;

                      /* Get the meta value of the custom field key. */
                      $meta_value = get_post_meta($post_id, $meta_key, true);

                      if (is_array($new_meta_value)) {
                          $tempNewMetaValue = array();
                          foreach ($new_meta_value as $key => $value) {
                              $tempNewMetaValue[] = $value;
                          }

                          $new_meta_value = $tempNewMetaValue;
                      }

                      /* If a new meta value was added and there was no previous value, add it. */
                      if ($new_meta_value !== $meta_value) {
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
	       <div class="container-fluid aBMB ab">
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
