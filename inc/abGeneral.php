<?php
if (!class_exists('GeneralFunctionality')) {
    class GeneralFunctionality
    {
        public function general_initialize()
        {
            // Hook for adding admin menus
            add_action('admin_footer', array($this, 'ab_admin_footer_function'));
            $this->loadEverything();

        }
        public function loadEverything()
        {
            // echo 'allright';
            // exit;
          //load from database entire string

          $dataArr = get_option('abAllArr');
            //load loop START
            // if we have data in the database, cycle trough it
            if (isset($dataArr) && !empty($dataArr)) {
                foreach ($dataArrAll as $dataArr) {
                    //version
                    $dataArr = $dataArr['sArr'];
                    $data = stripslashes($dataArr);
                    $dataArr = json_decode($data);
                  # code...
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

            //load loop END
        }
        //load new version into database
        public function loadNew($jsonString){
          $dataArr = get_option('abAllArr');

        }

        public function ab_admin_footer_function()
        {
            $bsIconsString = 'glyphicon-asterisk,glyphicon-plus,glyphicon-euro,glyphicon-eur,glyphicon-minus,glyphicon-cloud,glyphicon-envelope,glyphicon-pencil,glyphicon-glass,glyphicon-music,glyphicon-search,glyphicon-heart,glyphicon-star,glyphicon-star-empty,glyphicon-user,glyphicon-film,glyphicon-th-large,glyphicon-th,glyphicon-th-list,glyphicon-ok,glyphicon-remove,glyphicon-zoom-in,glyphicon-zoom-out,glyphicon-off,glyphicon-signal,glyphicon-cog,glyphicon-trash,glyphicon-home,glyphicon-file,glyphicon-time,glyphicon-road,glyphicon-download-alt,glyphicon-download,glyphicon-upload,glyphicon-inbox,glyphicon-play-circle,glyphicon-repeat,glyphicon-refresh,glyphicon-list-alt,glyphicon-lock,glyphicon-flag,glyphicon-headphones,glyphicon-volume-off,glyphicon-volume-down,glyphicon-volume-up,glyphicon-qrcode,glyphicon-barcode,glyphicon-tag,glyphicon-tags,glyphicon-book,glyphicon-bookmark,glyphicon-print,glyphicon-camera,glyphicon-font,glyphicon-bold,glyphicon-italic,glyphicon-text-height,glyphicon-text-width,glyphicon-align-left,glyphicon-align-center,glyphicon-align-right,glyphicon-align-justify,glyphicon-list,glyphicon-indent-left,glyphicon-indent-right,glyphicon-facetime-video,glyphicon-picture,glyphicon-map-marker,glyphicon-adjust,glyphicon-tint,glyphicon-edit,glyphicon-share,glyphicon-check,glyphicon-move,glyphicon-step-backward,glyphicon-fast-backward,glyphicon-backward,glyphicon-play,glyphicon-pause,glyphicon-stop,glyphicon-forward,glyphicon-fast-forward,glyphicon-step-forward,glyphicon-eject,glyphicon-chevron-left,glyphicon-chevron-right,glyphicon-plus-sign,glyphicon-minus-sign,glyphicon-remove-sign,glyphicon-ok-sign,glyphicon-question-sign,glyphicon-info-sign,glyphicon-screenshot,glyphicon-remove-circle,glyphicon-ok-circle,glyphicon-ban-circle,glyphicon-arrow-left,glyphicon-arrow-right,glyphicon-arrow-up,glyphicon-arrow-down,glyphicon-share-alt,glyphicon-resize-full,glyphicon-resize-small,glyphicon-exclamation-sign,glyphicon-gift,glyphicon-leaf,glyphicon-fire,glyphicon-eye-open,glyphicon-eye-close,glyphicon-warning-sign,glyphicon-plane,glyphicon-calendar,glyphicon-random,glyphicon-comment,glyphicon-magnet,glyphicon-chevron-up,glyphicon-chevron-down,glyphicon-retweet,glyphicon-shopping-cart,glyphicon-folder-close,glyphicon-folder-open,glyphicon-resize-vertical,glyphicon-resize-horizontal,glyphicon-hdd,glyphicon-bullhorn,glyphicon-bell,glyphicon-certificate,glyphicon-thumbs-up,glyphicon-thumbs-down,glyphicon-hand-right,glyphicon-hand-left,glyphicon-hand-up,glyphicon-hand-down,glyphicon-circle-arrow-right,glyphicon-circle-arrow-left,glyphicon-circle-arrow-up,glyphicon-circle-arrow-down,glyphicon-globe,glyphicon-wrench,glyphicon-tasks,glyphicon-filter,glyphicon-briefcase,glyphicon-fullscreen,glyphicon-dashboard,glyphicon-paperclip,glyphicon-heart-empty,glyphicon-link,glyphicon-phone,glyphicon-pushpin,glyphicon-usd,glyphicon-gbp,glyphicon-sort,glyphicon-sort-by-alphabet,glyphicon-sort-by-alphabet-alt,glyphicon-sort-by-order,glyphicon-sort-by-order-alt,glyphicon-sort-by-attributes,glyphicon-sort-by-attributes-alt,glyphicon-unchecked,glyphicon-expand,glyphicon-collapse-down,glyphicon-collapse-up,glyphicon-log-in,glyphicon-flash,glyphicon-log-out,glyphicon-new-window,glyphicon-record,glyphicon-save,glyphicon-open,glyphicon-saved,glyphicon-import,glyphicon-export,glyphicon-send,glyphicon-floppy-disk,glyphicon-floppy-saved,glyphicon-floppy-remove,glyphicon-floppy-save,glyphicon-floppy-open,glyphicon-credit-card,glyphicon-transfer,glyphicon-cutlery,glyphicon-header,glyphicon-compressed,glyphicon-earphone,glyphicon-phone-alt,glyphicon-tower,glyphicon-stats,glyphicon-sd-video,glyphicon-hd-video,glyphicon-subtitles,glyphicon-sound-stereo,glyphicon-sound-dolby,glyphicon-sound-5-1,glyphicon-sound-6-1,glyphicon-sound-7-1,glyphicon-copyright-mark,glyphicon-registration-mark,glyphicon-cloud-download,glyphicon-cloud-upload,glyphicon-tree-conifer,glyphicon-tree-deciduous,glyphicon-cd,glyphicon-save-file,glyphicon-open-file,glyphicon-level-up,glyphicon-copy,glyphicon-paste,glyphicon-alert,glyphicon-equalizer,glyphicon-king,glyphicon-queen,glyphicon-pawn,glyphicon-bishop,glyphicon-knight,glyphicon-baby-formula,glyphicon-tent,glyphicon-blackboard,glyphicon-bed,glyphicon-apple,glyphicon-erase,glyphicon-hourglass,glyphicon-lamp,glyphicon-duplicate,glyphicon-piggy-bank,glyphicon-scissors,glyphicon-bitcoin,glyphicon-btc,glyphicon-xbt,glyphicon-yen,glyphicon-jpy,glyphicon-ruble,glyphicon-rub,glyphicon-scale,glyphicon-ice-lolly,glyphicon-ice-lolly-tasted,glyphicon-education,glyphicon-option-horizontal,glyphicon-option-vertical,glyphicon-menu-hamburger,glyphicon-modal-window,glyphicon-oil,glyphicon-grain,glyphicon-sunglasses,glyphicon-text-size,glyphicon-text-color,glyphicon-text-background,glyphicon-object-align-top,glyphicon-object-align-bottom,glyphicon-object-align-horizontal,glyphicon-object-align-left,glyphicon-object-align-vertical,glyphicon-object-align-right,glyphicon-triangle-right,glyphicon-triangle-left,glyphicon-triangle-bottom,glyphicon-triangle-top,glyphicon-console,glyphicon-superscript,glyphicon-subscript,glyphicon-menu-left,glyphicon-menu-right,glyphicon-menu-down,glyphicon-menu-up';
            $bsIconsArr = explode(',', $bsIconsString);

            ?>
<div id="test-popup" class="open-popup-link white-popup mfp-hide">
<?php
foreach ($bsIconsArr as $key => $value) {
    ?>
  <button type="button"><i class="glyphicon <?php echo $value;
    ?>"></i></button>
  <?php

}

            ?>
</div>
<?php

        }
    // print an array properly
    public function showArr($arr, $exit = true)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        if ($exit) {
            exit;
        }
    }
        public function getField($optionName, $containerName, $fieldName)
        {
            $stringValues = get_option($optionName);

            $arrayValues = unserialize($stringValues);
            if (isset($arrayValues[$containerName][$fieldName])) {
                return $arrayValues[$containerName][$fieldName];
            }

            return '';
        }
    }
}
