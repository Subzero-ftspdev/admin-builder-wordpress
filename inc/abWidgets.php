<?php

class abWidgets
{
    /**
     * Holds the values to be used in the fields callbacks.
     */
    private $generalArr;
    /**
     * Start up.
     */
    public function __construct($generalArr)
    {
        add_action('widgets_init', function () {
            register_widget('abIntermediaryWidget');
        });
    }
}
global $dataArr;

class abIntermediaryWidget{
  public function __construct()
  {
    $dataArrXXX->label = 'test1';
    $dataArrXXX->name = 'test1Name';
    new abNewWidget($dataArrXXX);
    $dataArrXXX->label = 'test2';
    $dataArrXXX->name = 'test2Name';
    new abNewWidget($dataArrXXX);
  }
}
class abNewWidget extends WP_Widget
{
    public function __construct()
    {
      global $gDataArr,$abGen;
      // $abGen->showArr($gDataArr);

      if(isset($gDataArr->menus)){
        foreach ($gDataArr->menus as $key => $menu) {
          if(isset($menu->type)){
            if($menu->type==='widgets'){
              foreach ($menu->children as $key => $widget) {
                // $abGen->showArr($widget);
                $wName = (isset($widget->name))?$widget->name:'Default Widget id/name';
                $wLabel = (isset($widget->label))?$widget->label:'Default Widget Label';
                echo $wName;

                $widget_ops = array(
                    'classname' => $wName.'_class',
                    'description' => $wLabel." description",
                );
                parent::__construct($wName, $wLabel, $widget_ops);
              }
            }
          }
        }
      }
    }

    public function widget($args, $instance)
    {
    }

    public function form($instance)
    {
    }

    public function update($new_instance, $old_instance)
    {
    }
}
