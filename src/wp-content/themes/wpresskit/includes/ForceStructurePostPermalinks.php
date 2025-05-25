<?php
add_action('init', function() {
  update_option('permalink_structure', '/blog/%postname%/'); // Altere para a estrutura desejada
  flush_rewrite_rules();
});