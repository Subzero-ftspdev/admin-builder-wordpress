<?php

if (!class_exists('aBCPTClass')) {
    class aBCPTClass
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
        add_action('init', array($this, 'abRegisterPostType'));
    }
        public function abRegisterPostType()
        {
            $generalArr = $this->generalArr;
            if (isset($generalArr->menus)) {
                foreach ($generalArr->menus as $key => $value) {
                    if ($value->type === 'cpt') {
                        if (isset($value->label)) {
                            $args['label'] = $value->label;
                        }
                        if (isset($value->args->public)) {
                            $args['public'] = $value->args->public;
                        }
                // $aBGeneral = new GeneralFunctionality();
                // $aBGeneral->showArr($value->name);
                register_post_type($value->name, $args);
                    }
                }
            }
        }
    }
}
