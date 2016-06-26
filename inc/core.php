<?php
// generating the fields
require_once 'fields.php';
// generating meta boxes
require_once 'meta.php';
// general functionality
require_once 'general.php';
require_once 'cpt.php';
require_once 'cPages.php';

//
//
// Initializing the functionality
//
//

//initialize the class
// if (is_admin()) {
    //
    //General Functionality
    //load saved settings from the database ON LOAD
// $aBGeneral->initialize_menu();
    // $dataArr = $aBGeneral->loadDB();
    //
    // // meta boxes functionality
    // // custom post types
    // new aBCPTClass($dataArr);
    class loadFromPlugin
    {
        public function load($dataArr)
        {
          $data = stripslashes($dataArr);
          $dataArr = json_decode($data);
            // meta boxes functionality
            new aBMetaClass($dataArr);
            // custom post types
            new aBCPTClass($dataArr);
            new aBcPagesClass($dataArr);
            //custom pages class
        }
    }
// }
$abGen = new GeneralFunctionality();
$abGen->general_initialize();
