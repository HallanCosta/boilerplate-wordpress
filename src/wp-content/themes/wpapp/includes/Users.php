<?php 
add_action('admin_menu', function() {
  // Remove campos do usuário editor
  if (current_user_can('editor')) {
    remove_menu_page('edit.php?post_type=page');
    remove_menu_page('tools.php'); 
  }
});