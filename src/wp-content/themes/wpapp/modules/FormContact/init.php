<?php
$formContact = FormModel::createInstace([
  'cptTitleSingular' => 'Formulário Contact',
  'cptTitlePlural' => 'Formulário Contacts',
  'cptNameSingular' => 'form-contact',
  'cptNamePlural' => 'form-contacts',
  'cptLabelSingular' => 'Contact',
  'cptLabelPlural' => 'Contacts',
  'cptAddNewItem' => 'Adicionar novo Contact',
  'cptAllItems' => 'Todas os Contacts',
  'cptNotFound' => 'Nenhum Contact encontrado',
  'cptDescription' => 'Inscritos através do formulário Contact',

  'emailSubject' => 'Site WP APP - Contact',

  'data' => $_POST,
  'route' => 'form/contact', // http://localhost:3001/wp-json/wp-base-camp/form/contact

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
$formContact->run();

add_action('rest_api_init', function() use($formContact) {
  FormController::createInstance($formContact);
});