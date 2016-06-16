<?php

if (!class_exists('abSidebars')) {
    class abSidebars
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

        add_action('widgets_init', array($this, 'abRegisterSidebars'));
    }
        public function abRegisterSidebars()
        {
            $generalArr = $this->generalArr;
            if (isset($generalArr->menus)) {
                foreach ($generalArr->menus as $l1Key => $sidebars) {
                    // if we're dealing with a sidebar
          if (isset($sidebars->type) && $sidebars->type == 'sidebars') {
              // if the sidebar menu item is not empty
            if (!empty($sidebars->children)) {
                //cicle trough sidebars
              foreach ($sidebars->children as $l2Key => $sidebar) {
                  $sidebar->label = (isset($sidebar->label)) ? $sidebar->label : 'No Label';
                  $sidebar->name = (isset($sidebar->name)) ? $sidebar->name : 'No-Name';
                  $sidebar->description = (isset($sidebar->description)) ? $sidebar->description : 'No Description';
                  $sidebar->before_widget_id = (isset($sidebar->before_widget_id)) ? $sidebar->before_widget_id : '%1$s';
                  $sidebar->before_widget_class = (isset($sidebar->before_widget_class)) ? $sidebar->before_widget_class : 'widget %2$s';
                  $sidebar->before_title_class = (isset($sidebar->before_title_class)) ? $sidebar->before_title_class : 'widgettitle';
                  register_sidebar(array(
                                          'name' => __($sidebar->label, 'default'),
                                          'id' => $sidebar->name,
                                          'description' => __($sidebar->description, 'default'),
                                          'before_widget' => '<li id="'.$sidebar->before_widget_id.'" class="'.$sidebar->before_widget_class.'">',
                                          'after_widget' => '</li>',
                                          'before_title' => '<h2 class="'.$sidebar->before_title_class.'">',
                                          'after_title' => '</h2>',
                                        )
                                  );
              }
            }
          }
                }
            }
        }
    }
}
