<?php
class FormModel {
  public $cptTitleSingular = 'Formulário Contato';
  public $cptTitlePlural = 'Formulário Contatos';
  public $cptNameSingular = 'form-contact';
  public $cptNamePlural = 'form-contacts';
  public $cptLabelSingular = 'Contact';
  public $cptLabelPlural = 'Contacts';
  public $cptAddNewItem = 'Adicionar novo contato';
  public $cptAllItems = 'Todas os Contatos';
  public $cptNotFound = 'Nenhum contato encontrado';
  public $cptDescription = 'Inscritos através do formulário Contato';

  public $emailSubject;
  public $route;
  public $data;
  public $fields;
  public $postType;
  public $out = [];

  public function __construct($args) {
    $this->cptTitleSingular = $args['cptTitleSingular'];
    $this->cptTitlePlural = $args['cptTitlePlural'];
    $this->cptNameSingular = $args['cptNameSingular'];
    $this->cptNamePlural = $args['cptNamePlural'];
    $this->cptLabelSingular = $args['cptLabelSingular'];
    $this->cptLabelPlural = $args['cptLabelPlural'];
    $this->cptAddNewItem = $args['cptAddNewItem'];
    $this->cptAllItems = $args['cptAllItems'];
    $this->cptNotFound = $args['cptNotFound'];
    $this->cptDescription = $args['cptDescription'];
    $this->emailSubject = $args['emailSubject'];
    $this->fields = $args['fields'];
    $this->route = $args['route'];
    $this->data = $args['data'];

    $this->postType = $this->cptNameSingular;
  }

  public static function createInstace($args) {
    return new self($args);
  }

  public function run() {
    add_action('init', function() {
      $this->addCapabilitiesAdmin();
      $this->addCapabilitiesEditor();
      $this->registerCpt();
    });
    
    add_filter('manage_'.$this->postType.'_posts_columns', [$this, 'createColumnsDashboardList']);
    add_action('manage_'.$this->postType.'_posts_custom_column', [$this, 'addValuesColumnsDashboardList'], 10, 2);

    add_action('admin_menu', [$this, 'createMenu']);

    add_filter('post_row_actions', [$this, 'removeActions'], 10, 2);

    add_action('admin_head', [$this, 'styles']);
  }

  public function isValidRequest($data) {
    if (!check_email($data['email'])) {
      $this->out["staus"] = 400;
      $this->out["message"] = "Dados do formulários inválidos!";
      $this->out["data"] = $data;
      return false;
    }

    return true;
  }

  public function addCapabilitiesAdmin() {
    $roleAdministrator = get_role( 'administrator' );
    $roleAdministrator->add_cap( 'delete_published_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'delete_private_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'delete_others_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'delete_' . $this->postType, true );
    $roleAdministrator->add_cap( 'delete_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'read_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'edit_' . $this->postType, true );
    $roleAdministrator->add_cap( 'edit_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'publish_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'edit_published_' . $this->cptNamePlural, true );
    $roleAdministrator->add_cap( 'edit_others_' . $this->cptNamePlural, true );

    $roleAdministrator->add_cap( 'read_' . FormNotificationModel::$cptNamePlural, true );
  }

  public function addCapabilitiesEditor() {
    $roleEditor = get_role( 'editor' );
    $roleEditor->add_cap( 'delete_published_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'delete_private_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'delete_others_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'delete_' . $this->postType, true );
    $roleEditor->add_cap( 'delete_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'read_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'edit_' . $this->postType, true );
    $roleEditor->add_cap( 'edit_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'publish_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'edit_published_' . $this->cptNamePlural, true );
    $roleEditor->add_cap( 'edit_others_' . $this->cptNamePlural, true );

    $roleEditor->add_cap( 'read_' . FormNotificationModel::$cptNamePlural, true );
  }


  public function registerCpt() {
    $capabilities = [
      'delete_published_posts' => 'delete_published_' . $this->cptNamePlural,
      'delete_private_posts' => 'delete_private_' . $this->cptNamePlural,
      'delete_others_posts' => 'delete_others_' . $this->cptNamePlural,
      'delete_post' => 'delete_' . $this->postType,
      'delete_posts' => 'delete_' . $this->cptNamePlural,
      'create_posts' => false,//'create_' . $this->cptNamePlural, // false,
      'read_posts' => 'read_' . $this->cptNamePlural,
      'edit_post' => 'edit_' . $this->postType,
      'edit_posts' => 'edit_' . $this->cptNamePlural,
      'publish_posts' => 'publish_' . $this->cptNamePlural, // false,
      'edit_published_posts' => 'edit_published_' . $this->cptNamePlural,
      'edit_others_posts' => 'edit_others_' . $this->cptNamePlural
    ];

    $labels = [
      'name' => $this->cptTitleSingular,
      'name_admin_bar' => $this->cptTitleSingular,
      'singular_name' => $this->cptLabelSingular,
      'featured_image' => 'Imagem destacada',
      'set_featured_image' => 'Definir imagem destacada',
      'add_new_item' => $this->cptAddNewItem,
      'all_items' => $this->cptAllItems,
      'not_found' => $this->cptNotFound,
    ];

    $cpt = [
      'capabilities' => $capabilities,
      'labels' => $labels,
      //'menu_icon' => 'dashicons-buddicons-pm',
      'menu_icon' => 'dashicons-email-alt2',
      'description' => $this->cptDescription,
      //'public' => true,
      'public' => false,  // it's not public, it shouldn't have it's own permalink, and so on
      'publicly_queryable' => false,  // you should be able to query it
      'show_ui' => true,  // you should be able to edit it in wp-admin
      'exclude_from_search' => true,  // you should exclude it from search results
      'show_in_nav_menus' => false,  // you shouldn't be able to add it to menus
      'has_archive' => false,  // it shouldn't have archive page
      'rewrite' => false,  // it shouldn't have rewrite rules
      'supports' => [
        'title'
      ],
    ];

    register_post_type($this->postType, $cpt);
  }

  public function createMenu() {
    add_submenu_page(
      FormNotificationModel::$menuSlug, // Adicionar a entidade contato no slug menu Formulário (form-menu)
      $this->cptTitlePlural,
      $this->cptTitlePlural,
      'read_' . $this->cptNamePlural,
      'edit.php?post_type=' . $this->postType,
    );
     
    remove_menu_page( 'edit.php?post_type=' . $this->postType ); // Remove menu contato
  }

  public function templateEmail($data) {    
    $datetime = formatDateTime('now', 'Y-m-d H:i:s');
    $datetime_fmt = date('d/m/Y H:i', strtotime($datetime));

    $html = "
    <html>
      <head>
        <meta charset='UTF-8'>
        <title>Nova Mensagem de Contato</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #f5f5f5;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .header {
                text-align: center;
                padding-bottom: 20px;
                border-bottom: 2px solid #f0f0f0;
                margin-bottom: 30px;
            }
            .header h1 {
                color: #2c3e50;
                margin: 0;
                font-size: 24px;
            }
            .content {
                padding: 20px 0;
            }
            .info-item {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
            }
            .label {
                font-weight: bold;
                color: #34495e;
                width: 100px;
                display: inline-block;
            }
            .message-box {
                margin-top: 20px;
                padding: 15px;
                background-color: #f8f9fa;
                border-radius: 4px;
            }
            .footer {
                margin-top: 30px;
                text-align: center;
                color: #7f8c8d;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div style='padding-top: 40px; padding-bottom: 40px;'>
          <div class='container'>
              <div class='header'>
                  <h1>".$this->cptTitleSingular."</h1>
              </div>
              
              <div class='content'>
                  <div class='info-item'>
                      <span class='label'>Data:</span>
                      <span>$datetime_fmt</span>
                  </div>
                  ";
                  foreach ($this->fields as $field) {
                    $value = $data[$field['id']] ?? null;

                    $fieldValue = '';
                    if ($value === null) {
                      $fieldValue = $field['default'];
                    } else if (is_array($value)) {
                      $fieldValue = implode(', ', $data[$field['id']]);
                    } else {
                      $fieldValue = $value;
                    }

                    if ($field['id'] === 'message') {
                      $html .= "<div class='message-box'>";
                      $html .= "  <div class='label'>Mensagem:</div>";
                      $html .= "  <div style='margin-top: 10px;'>".$fieldValue."</div>";
                      $html .= "</div>";
                    } else {
                      $html .= "<div class='info-item'>";
                      $html .= "<span class='label'>".$field['name'].":</span>";
                      $html .= "<span>".$fieldValue."</span>";
                      $html .= "</div>";
                    }
                  }
                  ";
              </div>
              
              <div class='footer'>
                  <p>Este é um email automático.</p>
              </div>
          </div>
        </div>
      </body>
    </html>
    ";

    return $html;
  }

  public function getRWMBMetaFields() {
    return [
      'id' => $this->postType,
      'title' => 'Formulário de ' . $this->cptTitleSingular,
      'post_types' => [ $this->postType ],
      'context' => 'normal',
      'fields' => $this->fields
    ];
  }

  public function createColumnsDashboardList($columns) {
    unset($columns['date']);

    $countPostTitle = 0;
    foreach ($this->fields as $field) {
      if (isset($field['postTitle']) && $field['postTitle'] && $countPostTitle === 0) {
        $columns['title'] = $field['name'];
        $countPostTitle++;
      } elseif ($field['showOnList']) {
        $columns[$field['id']] = $field['name'];
      }
    }
    $columns['date'] = 'Data';
    
    return $columns;
  }

  public function addValuesColumnsDashboardList($columnName, $postId) {
    $countPostTitle = 0;
    foreach ($this->fields as $field) {
      if ($columnName === 'title' && isset($field['postTitle']) && $field['postTitle'] && $countPostTitle === 0) {
        echo rwmb_get_value($field['id'], [], $postId); // RWMB_METABOX
        $countPostTitle++;
      } elseif ($columnName === $field['id'] && $field['showOnList']) {
        echo rwmb_get_value($field['id'], [], $postId); // RWMB_METABOX
      }
    }

    if ($columnName == 'date') {
      echo '<abbr title="' . get_the_date('d/m/Y H:i:s', $postId) . '">' . get_the_date('d/m/Y H:i', $postId) . '</abbr>';
    }
  }

  public function removeActions($actions, $post) {
    if ($post->post_type == $this->postType)  {
      unset( $actions['view'] );
      unset( $actions['inline hide-if-no-js'] );
  
      unset( $actions['edit'] );
    }
    
    return $actions;
  }

  public function save($data) {
    if (!$this->isValidRequest($data)) {
      return false;
    }

    $fieldWithPostTitle = array_values(array_filter($this->fields, function ($field) {
      return !empty(isset($field['postTitle']) && $field['postTitle']);
    }));

    $fieldId = $fieldWithPostTitle[0]['id'] ?? $data[0];
    
    // Escreve a solicitação no banco de dados
    $postId = wp_insert_post([
      'post_status'   => 'publish',
      'post_type'     => $this->postType,
      'post_title'    => $data[$fieldId] // Pega o definido com postTitle
    ]);
    $data['id'] = $postId;

    foreach ($this->fields as $field) {
      $value = $data[$field['id']] ?? null;
      
      $fieldValue = '';
      if ($value === null) {
        $fieldValue = $field['default'];
        $data[$field['id']] = $field['default'];
      } else if (is_array($value)) {
        $fieldValue = implode(', ', $value);
      } else {
        $fieldValue = $value;
      }
      
      // RWMB Metabox
      rwmb_set_meta( $postId, $field['id'], $fieldValue);
      
      // ACF
      // update_field($postId, $field['id'], $postId);
    }

    $this->out["status"] = 201;
    $this->out["message"] = "Mensagem enviada com sucesso!";
    $this->out["recipients"] = FormNotificationModel::$recipients;
    $this->out["data"] = $data;

    return $this->out;
  }


  /**
   * Styles dashboard wordpress
   */
  public function styles() {
    global $post_type;
    
    if ($post_type == $this->postType) {
      ?>
      <style>
          /* Ocultar items da visualização do contato */
          #add_pod_button, 
          #misc-publishing-actions, 
          #minor-publishing-actions, 
          #postbox-container-1 { 
            display: none !important; 
          }

          #<?php echo $this->fields[0]['id'] ?>-label,
          input#<?php echo $this->fields[0]['id'] ?> {
            display: none;
          }
      </style>
      <?php
    }
  }
}