<?php
require_once __DIR__ . '/adapter.php'; 

$rwmbMetaFields = [];

$rwmbMetaFields[] = $formContact->getRWMBMetaFields();
$rwmbMetaFields[] = $formLead->getRWMBMetaFields();

RWMBMetaBoxAdapter::run($rwmbMetaFields);