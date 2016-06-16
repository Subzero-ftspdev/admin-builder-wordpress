<?php
//Admin scripts and styles
add_action('admin_enqueue_scripts','aBEnqueue');
//Admin scripts and styles callback
if(!function_exists('aBEnqueue')){
  function aBEnqueue(){
    global $rootURL;
    //plugin_dir_url( __FILE__ )
    //bootstrap style
    wp_register_style('aBBootstrap', $rootURL . 'css/bootstrap.min.css' );
    wp_enqueue_style('aBBootstrap');
    wp_register_style('jQueryUiCore', $rootURL . 'css/jquery-ui.css' );
    wp_enqueue_style('jQueryUiCore');
    wp_register_style('iris', $rootURL . 'css/iris.min.css' );
    wp_enqueue_style('iris');
    wp_register_style('timepicker', $rootURL . 'css/jquery.timepicker.css' );
    wp_enqueue_style('timepicker');
    //Magnific Popup
    wp_register_style('magnificPopupStyles', $rootURL .'css/magnific-popup.css' );
    wp_enqueue_style('magnificPopupStyles');
    //custom styles
    wp_register_style('aBStyles',$rootURL . 'css/style.css' );
    wp_enqueue_style('aBStyles');

    // library scripts
    //media upload script
    wp_enqueue_media();
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget',false,array('jquery-ui-core'));
    wp_enqueue_script('jquery-ui-mouse',false,array('jquery-ui-core'));
    wp_enqueue_script('jquery-ui-datepicker',false,array('jquery-ui-core'));
    wp_enqueue_script('jquery-ui-tabs',false,array('jquery','jquery-ui-core'));
    wp_enqueue_script('jquery-ui-draggable',false,array('jquery-ui-core','jquery-ui-widget','jquery-ui-mouse'));
    wp_enqueue_script('jquery-ui-slider',false,array('jquery-ui-core','jquery-ui-widget','jquery-ui-mouse'));

    wp_register_script('aBbootrap', $rootURL. 'js/bootstrap.min.js' );
    wp_enqueue_script('aBBootrap');
    wp_register_script('aBColor', $rootURL . 'js/color.js' );
    wp_enqueue_script('aBColor');
    wp_register_script('aBIris', $rootURL. 'js/iris.js',array('jquery-ui-core','jquery-ui-draggable','jquery-ui-slider') );
    wp_enqueue_script('aBIris');
    //colorpicker
    wp_register_script('aBTimepicker', $rootURL . 'js/jquery.timepicker.min.js',array('jquery-ui-core'));
    wp_enqueue_script('aBTimepicker');
    // Magnific Popup script
    wp_register_script('magnificPopup', $rootURL. 'js/jquery.magnific-popup.min.js',array('jquery','jquery-ui-core') );
    wp_enqueue_script('magnificPopup');

    // custom script
    wp_register_script('aBScript', $rootURL . 'js/script.js' );
    wp_enqueue_script('aBScript');
  }
}
