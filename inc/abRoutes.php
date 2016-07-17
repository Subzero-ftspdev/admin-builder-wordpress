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
          add_action('rest_api_init', array($this, 'abRoutesInit'));
      }
        public function abRoutesInit()
        {
            global $abGen;

            foreach ($this->generalArr->menus as $key) {
                if ($key->type == 'restRoutes') {
                    if (!empty($key->children)) {
                        foreach ($key->children as $cKey) {
                            // $abGen->showArr($cKey);

                            $callbackFunction = (isset($cKey->callbackFunction)) ? $cKey->callbackFunction : function () {};
                            $namespace = (isset($cKey->namespace)) ? $cKey->namespace : '';
                            $route_path = (isset($cKey->route_path) && !empty($cKey->route_path)) ? $cKey->route_path : '';
                            $rRMethod = (isset($key->rRMethod) && $key->rRMethod === 'post') ? 'POST' : 'GET';
                            register_rest_route($namespace, $route_path,
                            array(
                              'methods' => $rRMethod,
                              'callback' => $callbackFunction,
                              'args' => array(
                                'id' => array(
                                  'validate_callback' => function ($param, $request, $key) {
                                    return is_numeric($param);
                                  },
                                ),
                              ),
                            ));
                        }
                    }
                }
            }
        }
    }
}
