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
          // $abGen->showArr($generalArr);
          add_action('init',array($this,'abRoutesInit'));
      }
      public function abRoutesInit(){
        
      }
    }
}
