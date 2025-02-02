<?php
require_once __DIR__ . '/model.php'; 
require_once __DIR__ . '/controller.php'; 

FormNotificationModel::run();

add_action('rest_api_init', function() {
  FormNotificationController::run();
});