<?php

if (!class_exists('abRoutes')) {
    class abRoutes
    {
        private $generalArr;
      /**
       * Start up.
       */
      public function __construct($generalArr)
      {
        global $abGen;
          $this->generalArr = $generalArr;
          add_action('init',array($this,'abRoutesInit'));
      }
      public function abRoutesInit(){
        global $abGen;

        foreach ($this->generalArr->menus as $key) {
          if($key->type=='restRoutes'){
            if(!Empty($key->children)){
              foreach ($key->children as $cKey) {
                $abGen->showArr($cKey);
                # code...
              }
            }
          }
        }

      }
    }
}
