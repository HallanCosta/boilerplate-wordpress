<?php

require_once __DIR__ . '/adapter.php'; 

$rwmbMetaFields = [];

// $rwmbMetaFields[] = FormContactModel::getRWMBMetaFields();
// $rwmbMetaFields[] = FormLeadModel::getRWMBMetaFields();
$rwmbMetaFields[] = $formHallan->getRWMBMetaFields();
$rwmbMetaFields[] = $formContact->getRWMBMetaFields();
$rwmbMetaFields[] = $formLead->getRWMBMetaFields();

RWMBMetaBoxAdapter::run($rwmbMetaFields);