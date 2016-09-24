<?php
if (!class_exists('fieldsC')) {
    class fieldsC
    {
        // add simple textbox field
      public function addMeta_field($args, $fType = '', $allValues = array(), $pageName = '')
      {
          $sGeneral = new GeneralFunctionality();

          switch ($fType) {
        case 'cPage':
          $args = (array) $args;
          $field = $args ? $args : '';
          $metaboxName = $args['name'] ? $args['name'] : '';
          $post = $args ? $args : '';
          $prefix = $fType.'['.$pageName.']'.'['.$args['name'].']';
          $fieldValue = '';
          if (!empty($allValues)) {
              foreach ($allValues as $key => $value) {
                  foreach ($value as $key2 => $value2) {
                      if ($key2 === $args['name'] && $pageName === $key) {
                          $fieldValue = $value2;
                      }
                  }
              }
          }
        break;
        default:
          $field = $args[0] ? $args[0] : '';
          $metaboxName = $args[1]['name'] ? $args[1]['name'] : '';
          $prefix = 'abMB_'.$metaboxName.$field['name'];
          $post = $args[2] ? $args[2] : '';

        break;
      }
      //--
      //end switch
      //--
      $fieldName = esc_attr($prefix);
          $type = $field['type'] ? $field['type'] : null;

          if (isset($field['post_status'])) {
              $post_status = $field['post_status'] ? $field['post_status'] : '';
          } else {
              $post_status = '';
          }
          if (isset($post->ID)) {
              $fieldValue = get_post_meta($post->ID, $fieldName, true);
          }
          $label = $field['label'];
          $description = $field['description'];
          $fieldHTML = '';
          switch ($type) {
          case 'textbox':
          $fieldHTML = '<input class="widefat" type="text" name="'.$fieldName.'"  id="'.$fieldName.'" value="'.$fieldValue.'" size="30" />';
          break;
          case 'textarea':
          $fieldHTML = '<textarea name="'.$fieldName.'" id="'.$fieldName.'" class="widefat" rows="8" cols="40">'.$fieldValue.'</textarea>';
          break;
          case 'checkbox':
          $extraText = $field['extraText'] ? $field['extraText'] : '';
          $fieldHTML = '<input type="checkbox" name="'.$fieldName.'"  id="'.$fieldName.'" '.checked('on', $fieldValue, false).' size="30" /> <span class="extraText">'.$extraText.'</span>';
          break;
          case 'select':
          $customList = $field['oArr'] ? $field['oArr'] : array('label' => '0', 'value' => 'Empty');
          //lines into array
          $fieldHTML = '<select name="'.$fieldName.'" id="'.$fieldName.'">';
          switch ($field['selectType']) {
            case 'custom':
            foreach ($customList as $key => $option) {
                //comma separated string into array
                $optionValue = '';
                if (isset($option->value)) {
                    $optionValue = $option->value;
                }
                $optionLabel = '';

                if (isset($option->label)) {
                    $optionLabel = $option->label;
                }
                $selected = selected($optionValue, $fieldValue, false) ? selected($optionValue, $fieldValue, false) : '';
              //set the options
              $fieldHTML .= '<option  '.$selected.' value="'.$optionValue.'" >'.$optionLabel.'</option>';
            }
            $fieldHTML .= '<select>';
            break;
            case 'categories':
            $customList = get_categories(
                                        array(
                                            'orderby' => 'name',
                                            'order' => 'ASC',
                                            'hide_empty' => 0,
                                        )
                                      );

            //lines into array
            foreach ($customList as $option) {
                //comma separated string into array
              $selected = selected($option->slug, $fieldValue, false) ? selected($option->slug, $fieldValue, false) : '';
              //set the options
              $fieldHTML .= '<option  '.$selected.' value="'.$option->slug.'" >'.$option->name.'</option>';
            }
            break;
            case 'tags':
            $customList = get_tags(
                                    array(
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                        'hide_empty' => 0,
                                    )
                                  );

            //lines into array
            foreach ($customList as $option) {
                $optionSlug = '';
                if (isset($option->slug)) {
                    $optionSlug = $option->slug;
                }
                if (isset($option->name)) {
                    $optionName = $option->name;
                }
                //comma separated string into array
              $selected = selected($optionSlug, $fieldValue, false) ? selected($optionSlug, $fieldValue, false) : '';
              //set the options
              $fieldHTML .= '<option  '.$selected.' value="'.$optionSlug.'" >'.$optionName.'</option>';
            }
            break;
            case 'pages':
            $customList = get_posts(
                                    array(
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                        'hide_empty' => 0,
                                        'post_type' => 'page',
                                        'post_status' => $post_status,
                                    )
                                  );

            //lines into array
            foreach ($customList as $page) {
                $pageID = 0;
                if (isset($page->ID)) {
                    $pageID = $page->ID;
                }
                $pageTitle = 0;
                if (isset($page->post_title)) {
                    $pageTitle = $page->post_title;
                }
                //comma separated string into array
            $selected = selected($pageID, $fieldValue, false) ? selected($pageID, $fieldValue, false) : '';
            //set the options
            $fieldHTML .= '<option  '.$selected.' value="'.$pageID.'" >'.$pageTitle.'</option>';
            }
            $fieldHTML .= '</select>';

            break;
            case 'posts':
            $customList = get_posts(
                                    array(
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                        'hide_empty' => 0,
                                        'post_type' => 'post',
                                        'post_status' => $post_status,
                                    )
                                  );
            //lines into array
            foreach ($customList as $post) {
                //comma separated string into array
              $selected = selected($post->ID, $fieldValue, false) ? selected($post->ID, $fieldValue, false) : '';
              //set the options
              $fieldHTML .= '<option  '.$selected.' value="'.$post->ID.'" >'.$post->post_title.$fieldValue.'</option>';
            }

            break;
            case 'users':
            $argsx = array();
              $customList = get_users($argsx);
            //lines into array
            foreach ($customList as $usr) {
                //comma separated string into array
              $selected = selected($usr->ID, $fieldValue, false) ? selected($usr->ID, $fieldValue, false) : '';
              //set the options
              $fieldHTML .= '<option  '.$selected.' value="'.$usr->ID.'" >'.$usr->user_login.'</option>';
            }

            break;
          }
          //
          //END of select types switch
          //
          $fieldHTML .= '</select>';
          break;
          case 'datepicker':
          $fieldHTML = '<input class="aBDatepicker" type="text" data-dateformat="'.$field['format'].'" name="'.$fieldName.'"  id="'.$fieldName.'" value="'.$fieldValue.'" readonly size="20" />';
          break;
          case 'timepicker':
          $fieldHTML = '<input class="aBTimepicker" type="text" name="'.$fieldName.'" id="'.$fieldName.'" value="'.$fieldValue.'" size="10" />';
          break;
          case 'colorpicker':
          $fieldHTML = '<input class=" aBColorpicker" readonly type="text" name="'.$fieldName.'"  id="'.$fieldName.'" value="'.$fieldValue.'" size="10" />';
          break;
          case 'radio':
          if (isset($field['radioType']) && $field['radioType'] === 'custom') {
              $fieldHTML = '';
              foreach ($field['oArr'] as $radio) {
                  $radioValue = '';
                  if (isset($radio->value)) {
                      $radioValue = $radio->value;
                  }
                  $radioLabel = '';
                  if (isset($radio->label)) {
                      $radioLabel = $radio->label;
                  }
                  $tempChecked = checked($radioValue, $fieldValue, false);
                  $checked = $tempChecked ? $tempChecked : '';

                  $fieldHTML .= '<input type="radio" name="'.$fieldName.'" '.$checked.' value="'.$radioValue.'"> '.$radioLabel.' ';
                  if ($field['orientation'] === 'v') {
                      //add new line if orientation is set to vertical
                $fieldHTML .= '<br/>';
                  }
              }
          }
          break;
          case 'upload':
          $buttonString = 'Upload';
          $imgAlt = '';
          if (!empty($fieldValue)) {
              $buttonString = 'Remove';
              $imgAlt = 'No Image Uploaded';
          }
          $fieldHTML .= '<p><img src="'.$fieldValue.'" alt="'.$imgAlt.'" class="uploadImage"/></p>';
          $fieldHTML .= '<button class="aBUpload">'.$buttonString.'</button><br/><br/>';
          $fieldHTML .= '<input type="hidden" name="'.$fieldName.'" value="'.$fieldValue.'" />';
          break;
          case 'bootstrapIcons':
          $buttonString = 'Select an Icon';
          $imgAlt = '';
          if (!empty($fieldValue)) {
              $buttonString = '<i class="glyphicon '.$fieldValue.'"></i>';
              $imgAlt = 'No Image Uploaded';
          }
          $fieldHTML .= '<button type="button" class="abBootstrapIcons">'.$buttonString.'</button><br/><br/>';
          $fieldHTML .= '<input type="hidden" class="abBIHidden" name="'.$fieldName.'" value="'.$fieldValue.'" />';
          break;
          case 'textboxesDynamic':
          // $sGeneral->showArr($fieldValue);

          $oArr = (isset($field['oArr'])) ? $field['oArr'] : array();
          $fieldHTML .= '<div class="hidden tbdContent">';
          $fieldHTML .= '<div class="groupContainer">';
          $fieldHTML .= '<button type="button" class="btn btn-primary close">X</button>';
          foreach ($oArr as $key) {
              $fieldHTML .= $this->dtGenerate($key->label, $fieldName, null, null, $key->value);
          }
          $fieldHTML .= '</div>';
          $fieldHTML .= '</div>';

          $imgAlt = '';
          $fieldHTML .= '<div class="tdOutput">';
          // $sGeneral->showArr($fieldValue);

          if (is_array($fieldValue)) {
              //
          $i = 0;

              foreach ($fieldValue as $fv) {
                  $fieldHTML .= '<div class="groupContainer">';
                  $fieldHTML .= '<button type="button" class="btn btn-primary close">X</button>';
                  foreach ($oArr as $key => $val) {
                      $fieldValue = (isset($fv[$val->value])) ? $fv[$val->value] : '';
                      $fieldHTML .= $this->dtGenerate($val->label, $fieldName, $fv[$val->value], $i, $val->value);
                  }
                  $fieldHTML .= '</div>';
                  ++$i;
              }
          }

          $fieldHTML .= '</div>';
          $fieldHTML .= '<p><button type="button" class="tbdAdd btn btn-primary">Add Row</button><br/></p>';
          break;
        }
          ?>
            <div class="row abList">
              <div class="col-sm-2">
                <label class="title"><?php _e($label);
          ?></label>
              </div>

           <div class="col-sm-10">
              <?php
              echo $fieldHTML;
          ?>
              <label class="description">* <?php _e($description);
          ?> </label>
          </div>
        </div>

        <?php

      }
      //dynamic textbox generate
      private function dtGenerate($label, $name, $value, $index = null, $attr = null)
      {
          $arrName = $name;
          $origNameStr = 'origName="'.$name.'" ';
          if ($index !== null && !empty($attr) && !empty($attr)) {
              $arrName = $name.'['.$index.']['.$attr.']';
          }

          $attrStr = '';
          if ($attr != null && !empty($attr)) {
              $attrStr = 'dtArrName="'.$attr.'" ';
          }
          $fieldHTML = '<div class="form-group">';
          $fieldHTML .= '<label for="'.$name.'">'.$label.'</label>';
          $fieldHTML .= '<input type="text" name="'.$arrName.'" '.$origNameStr.'  class="form-control" '.$attrStr.' placeholder="Please enter '.$label.'" value="'.$value.'">';
          $fieldHTML .= '</div>';

          return $fieldHTML;
      }
    }
}
