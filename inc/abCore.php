<?php
// generating the fields
require_once 'abFields.php';
// generating meta boxes
require_once 'abMeta.php';
// general functionality
require_once 'abGeneral.php';
// custom post type functionality
require_once 'abCpt.php';
// custom admin pages functionality
require_once 'abCPages.php';
// sidebars functionality
require_once 'abSidebars.php';
//widgets functionality
//
//
// Initializing the functionality
//
//
if(!class_exists('loadFromPlugin')){
  class loadFromPlugin
  {
      public function load($dataArr)
      {
        global $gDataArr ;
          $data = stripslashes($dataArr);

          $dataArr = json_decode($data);
          $gDataArr = $dataArr;
          // meta boxes functionality
          new aBMetaClass($dataArr);
          // custom post types
          new aBCPTClass($dataArr);
          //custom page class
          new aBcPagesClass($dataArr);
          //custom sidebars
          new abSidebars($dataArr);
          // custom widgets Class
      }
  }
}
$abGen = new GeneralFunctionality();
$abGen->general_initialize();
