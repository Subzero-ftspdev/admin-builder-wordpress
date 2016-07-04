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
//widgets functionalityz`b
//
//
// Initializing the functionality
//
//
$abGen = new GeneralFunctionality();

$abGen->general_initialize();
