<?php 

class FormNotificationController extends WP_REST_Controller {
  public static function run() {
    self::registerRoutes(FormNotificationModel::$postType);
  }

  public static function registerRoutes($baseEndpoint) {
    register_rest_route('wpresskit/v1', 'form/notification', [
      'methods' => 'POST',
      'callback' => [__CLASS__, 'save'],
    ]); // http://localhost:3001/wp-json/wpresskit/v1/form/notification
  }

  public static function save() {
    $subject = 'WPressKit - Notificação - Independente';
    $mailResponse = EmailService::sendMail(
      $subject,
      FormNotificationModel::templateEmail($subject, $_POST), 
      FormNotificationModel::$recipients
    );

    return new WP_REST_Response([
      'mail_response' =>  $mailResponse,
      'recipients' => FormNotificationModel::$recipients
    ], 200);
  }
}