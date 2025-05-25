<?php
add_action('rest_api_init', function() {
  CommentController::run(); 
});