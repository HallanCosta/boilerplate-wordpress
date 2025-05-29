<?php
require_once __DIR__ . '/model.php'; 
require_once __DIR__ . '/controller.php'; 
// require_once __DIR__ . '/routes.php'; 

$formHallan = FormModel::createInstace([
  'cptTitleSingular' => 'Formulário Hállan',
  'cptTitlePlural' => 'Formulário Hállans',
  'cptNameSingular' => 'form-hallan',
  'cptNamePlural' => 'form-hallans',
  'cptLabelSingular' => 'Contact',
  'cptLabelPlural' => 'Contacts',
  'cptAddNewItem' => 'Adicionar novo Hállan',
  'cptAllItems' => 'Todas os Hállans',
  'cptNotFound' => 'Nenhum Hállan encontrado',
  'cptDescription' => 'Inscritos através do formulário Hállan',

  'emailSubject' => 'Site WPressKit - Hállan',

  'data' => $_POST,
  'route' => 'form/hallan', // http://localhost:3001/wp-json/wpresskit/v1/form/hallan

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
    ],
    [
      'id' => 'client_ip',
      'name' => 'IP do Cliente',
      'type' => 'text',
      'placeholder' => '127.0.0.1',
      'default' => getClientIP(), // Valor padrão 
      'desc' => '',
      'showOnList' => true,
    ],
  ]
]);
$formHallan->run();