<?php
add_action('admin_menu','ab_add_pages');

function ab_add_pages(){
  add_menu_page('Admin Builder', 'Admin Builder', 'manage_options', 'admin-builder-settings', 'abSettings');

}
function abSettings(){
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
  $getPage = (isset($_POST['page']))?$_POST['page']:'admin-builder-settings';
  $link = '?page='.$getPage;
  foreach ($abAllArr as $key) {
    ?>
    <div class="abPageRow">
      [ <a href="<?php echo $link;?> "> X Delete</a> ]  <?php echo $key['name']; ?>
    </div>
    <?php
  }

}
