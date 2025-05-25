<?php
$formLead = FormModel::createInstace([
  'cptTitleSingular' => 'Formulário Lead',
  'cptTitlePlural' => 'Formulário Leads',
  'cptNameSingular' => 'form-lead',
  'cptNamePlural' => 'form-leads',
  'cptLabelSingular' => 'Lead',
  'cptLabelPlural' => 'Leads',
  'cptAddNewItem' => 'Adicionar novo Lead',
  'cptAllItems' => 'Todas os Leads',
  'cptNotFound' => 'Nenhum Lead encontrado',
  'cptDescription' => 'Inscritos através do formulário Lead',

  'emailSubject' => 'Site WPressKit - Lead',

  'data' => $_POST,
  'route' => 'form/lead', // http://localhost:3001/wp-json/wpresskit/v1/form/lead

  'fields' => [
    [
      'id' => 'name',
      'name' => 'Nome',
      'type' => 'text',
      'placeholder' => '',
      'desc' => '',
      'maxlength' => 255,
      'showOnList' => true, // Qual vai aparecer na dashboard
      'postTitle' => true, // Somente um pode ter postTitle, mais de um será ignorado (postTitle ignora o showOnList)
    ],
    [
      'id' => 'email',
      'name' => 'E-Mail',
      'type' => 'text',
      'placeholder' => 'email@hotmail.com',
      'desc' => '',
      'showOnList' => true,
    ],
    [
      'id' => 'whatsapp',
      'name' => 'Whatsapp',
      'type' => 'text',
      'placeholder' => '(00) 00000-0000',
      'desc' => '',
      'showOnList' => true,
    ],
    [
      'id' => 'cnpj',
      'name' => 'CNPJ',
      'type' => 'text',
      'placeholder' => 'XX.XXX.XXX/0001-XX',
      'desc' => '',
      'showOnList' => true,
    ],
    [
      'id' => 'state',
      'name' => 'Estado',
      'type' => 'text',
      'placeholder' => '',
      'desc' => '',
      'showOnList' => true,
    ],
    [
      'id' => 'zipcode',
      'name' => 'CEP',
      'type' => 'text',
      'placeholder' => '00000-000',
      'desc' => '',
      'showOnList' => true,
    ],
    [
      'id' => 'message',
      'name' => 'Mensagem',
      'type' => 'text',
      'placeholder' => '',
      'desc' => '',
      'showOnList' => true,
    ]
  ]
]);
$formLead->run();

add_action('rest_api_init', function() use($formLead) {
  FormController::createInstance($formLead)->registerRoutes();
});