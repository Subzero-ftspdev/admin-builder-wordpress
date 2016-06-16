<?php
if (!class_exists('aBcPagesClass')) {
    class aBcPagesClass
    {
        /**
   * Holds the values to be used in the fields callbacks.
   */
  private $generalArr;
  // private $options;
  /**
   * Start up.
   */
  public function __construct($generalArr)
  {
      $this->generalArr = $generalArr;
// Hook for adding admin menus
add_action('admin_menu', array($this, 'mt_add_pages'));
  }

  // action function for above hook
  public function mt_add_pages()
  {
      $generalArr = $this->generalArr;
      if (isset($generalArr->menus)) {
          foreach ($generalArr->menus as $key => $value) {
              if ($value->type === 'cPage') {
                  $handler = (isset($value->handler)) ? $value->handler : 'top_level_handle';
                  $capability = (isset($value->capability)) ? $value->capability : 'manage_options';
                  $pageTitle = (isset($value->pageTitle)) ? $value->pageTitle : 'Default Custom page title';
                  $position = (isset($value->position)) ? $value->position : null;
                  $icon_url = (isset($value->icon_url)) ? $value->icon_url : '';

                  add_menu_page($pageTitle, $value->label, $capability, $handler, array($this, 'ab_toplevel_page'), $icon_url, $position);
              }
          }
      }
  }
        public function saveArrayFields($hidden_field_name, $hidden_field_value)
        {
            if (empty($_POST)) {
                return false;
            }
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if (isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == $hidden_field_value) {
        $fullPostString = '';
        // Read their posted value
        if (isset($_POST['cPage'])) {
            $fullPostString = serialize($_POST['cPage']);
        }

        // Save the posted value in the database
        update_option($hidden_field_name, $fullPostString);

        // Put a "settings saved" message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test');
        ?></strong></p></div>
<?php

    }
        }
        public function loadcPage($hidden_field_name)
        {
            $stringValues = get_option($hidden_field_name);

            return unserialize($stringValues);
        }
  // Admin Menu callback function
    public function ab_toplevel_page()
    {
        $generalArr = $this->generalArr;
        ?>
      <form name="abForm" class="abForm" method="post" action="">
      <?php
        foreach ($generalArr->menus as $key => $value) {
            if ($value->type === 'cPage') {
                if ($_GET['page'] === $value->handler) {
                    $pageTitle = (isset($value->pageTitle)) ? $value->pageTitle : 'Custom Page Title';
                    $pageDescription = (isset($value->pageDescription)) ? $value->pageDescription : 'Custom Page Description';
                    ?>
                  <h2><?php echo $pageTitle;
                    ?></h2>
                  <p class="pageDescription">
                    <?php echo $pageDescription;
                    ?>
                  </p>

                  <?php

                  //must check that the user has the required capability
                      if (!current_user_can($value->capability)) {
                          wp_die(__('You do not have sufficient permissions to access this page.'));
                      }

                  //save all the fields
                  $hiddenFieldName = 'abOption_'.$value->type.'_'.$value->name;
                    $hiddenFieldValue = $value->type.'_'.$value->name.'hfv#$1!';
                    $this->saveArrayFields($hiddenFieldName, $hiddenFieldValue);
                    ?>
                  <input type="hidden" name="<?php echo $hiddenFieldName;
                    ?>" value="<?php echo $hiddenFieldValue;
                    ?>" />

                  <?php
                  $allValues = $this->loadcPage($hiddenFieldName); //Get all the Values for the fields of this page in one big array
                  if (sizeof($value->children) > 1) {
                      ?>
                  <div id="abTabs">

                  <ul class="nav nav-tabs">
                    <?php

                  }
                    if (sizeof($value->children) > 1) {
                        $i = 0;
                    //generate the tabs
                        foreach ($value->children as $tKey => $tValue) {
                            $activeClass = '';
                            if ($i === 0) {
                                $activeClass = ' active ';
                            }
                            ?>
                        <li role="presentation" class="<?php echo $activeClass;
                            ?>"><a href="#<?php echo $tValue->name;
                            ?>" aria-controls="<?php echo $tValue->name;
                            ?>" role="tab" data-toggle="<?php echo $tValue->name;
                            ?>"><?php echo $tValue->label;
                            ?></a></li>
                      <?php
                      ++$i;
                        }
                    }
                    ?>
                  </ul>
                    <!-- Tab panes -->
                    <?php
                    if (sizeof($value->children) > 1) {
                        ?>
                      <div class="tab-content">
                    <?php

                    }
                    $i = 0;
                    //get all the settings for a custom admin page
                      foreach ($value->children as $tKey => $tValue) {
                          $activeClass = '';
                          if ($i === 0) {
                              $activeClass = ' active ';
                          }
                          $tabTitle = (isset($tValue->label)) ? $tValue->label : 'Tab';
                          if (sizeof($value->children) > 1) {
                              ?>
                          <div role="presentation" class="tab-pane <?php echo $activeClass;
                              ?>" id="<?php echo $tValue->name;
                              ?>">
                        <?php

                          }
                          //get each tab
                          foreach ($tValue->fields as $fKey => $fValue) {
                              $fieldsC = new fieldsC();
                              $args = $fValue;
                            //
                            // Generate Tab Fields
                            //
                            $fieldsC->addMeta_field($args, 'cPage', $allValues, $tValue->name);

                            ///
                          }
                          if (sizeof($value->children) > 1) {
                              ?>
                        </div>
                          <?php

                          }
                          ++$i;
                      }
                    if (sizeof($value->children) > 1) {
                        ?>
                  </div>
                    <?php

                    }
                }
            }
        }
        ?>
        <p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
        <?php

    }
    }
}
