<?php
add_action('admin_menu', 'ab_add_pages');

function ab_add_pages()
{
    add_menu_page('Admin Builder', 'Admin Builder', 'manage_options', 'admin-builder-settings', 'abSettings');
}
function abSettings()
{
    ?>
  <h3>Admin Builder Settings</h3>
  <p>
    Use this page to configure which settings from the database should exist or not. Delete the ones that shouldn't run.
  </p>
  <h4>Active Database Settings:</h4>
  <p>
    These are all the settings that are loaded from the database. Click delete to remove them.
  </p>
  <?php
  $abAllArr = get_option('abAllArr');
    $abAllArr = unserialize($abAllArr);
    $getPage = (isset($_GET['page'])) ? $_GET['page'] : 'admin-builder-settings';
    $link = '?page='.$getPage;
    $newabAllArr = array();
    foreach ($abAllArr as $key) {
      $del = (isset($_GET['del']))?$_GET['del']:'';
        if (isset($_GET['page']) && $_GET['page'] === 'admin-builder-settings' && isset($_GET['del']) && $key['name'] === $_GET['del']) {
            continue;
        }
        $newabAllArr[] = $key;
        $link .= '&del='.$key['name'];
        ?>
    <div class="abPageRow">
      [ <a href="<?php echo $link;
        ?> "> X Delete</a> ]  <?php echo $key['name'];
        ?>
    </div>
    <?php

    }
    if (isset($_GET['page']) && $_GET['page'] === 'admin-builder-settings' && isset($_GET['del'])) {
        $newabAllArr = serialize($newabAllArr);
        update_option('abAllArr', $newabAllArr);
    }
}
