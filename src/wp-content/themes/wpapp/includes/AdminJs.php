<?php 
// Importação do bundle no javascript admin
add_action('admin_enqueue_scripts', function() {
  wp_enqueue_script(
    get_template_directory() . '/bundle.js',  // Handle do script
    get_template_directory_uri() . '/bundle.js',   // Caminho para o arquivo JS
    ['jquery'],            // Dependências (ex: ['jquery'])
    getAppVersion(),      // Versão (baseada na data/hora de modificação)
    true           // Carregar no footer
  );
  
  wp_localize_script( 
    get_template_directory() . '/bundle.js', 
    '$Injection', // Nome do objeto JavaScript
    [
      'ajaxUrl' => admin_url('admin-ajax.php'), // URL para requisições AJAX
      'nonce'   => wp_create_nonce('assodeere_nonce'), // Nonce para segurança
    ]
  );
});