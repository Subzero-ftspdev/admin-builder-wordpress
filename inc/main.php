<?php


     //must check that the user has the required capability
     if (!current_user_can('manage_options')) {
         wp_die(__('You do not have sufficient permissions to access this page.'));
     }

     // variables for the field and option names
     $opt_name = 'aBData';
     $hidden_field_name = 'mt_submit_hidden';
     $data_field_name = 'aBData';

     // Read in existing option value from database
     $opt_val = stripslashes(get_option($opt_name));

     // See if the user has posted us some information
     // If they did, this hidden field will be set to 'Y'
     if (isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y') {
         // Read their posted value
         $opt_val = stripslashes($_POST[ $data_field_name ]);

         // Save the posted value in the database
         update_option($opt_name, $opt_val);

         // Put a "settings saved" message on the screen

   ?>
   <div class="updated"><p><strong><?php _e('settings imported succesfully.', 'menu-test');
         ?></strong></p></div>
   <?php

     }
     ?>
<h3>Admin Builder Settings</h3>
<p>
  Use <b><a href="http://admin-builder.com">Admin Builder</a></b> to generate the json string. Copy it from the settings and,
</p>
<p>
  Import here:
</p>
<form action="" method="post" class="aBForm">
  <p>
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <textarea class="form-control" name="aBData" rows="8"><?php echo $opt_val; ?></textarea>
  </p>

  <input type="submit" class="btn btn-primary" name="name" value="Import" />
</form>
