<?php 
class CommentController extends WP_REST_Controller {
  public static string $baseEndpoint;

  public static function run() {
    self::registerRoutes(CommentModel::$postType);
  }

  public static function registerRoutes($baseEndpoint) {
    register_rest_route($baseEndpoint, '/register', [
      'methods' => 'POST',
      'callback' => [__CLASS__, 'save'],
    ]); // http://localhost:3001/wp-json/comment/register
  }

  public static function save() {
    $commentResponse = CommentModel::save($_POST);

    if (!$commentResponse) {
      return new WP_REST_Response([
        'response' => CommentModel::$out, 
        'mail_response' =>  false
      ], 400);
    } 

    // $subject = 'Site WP APP - Contato';
    // $mailResponse = EmailService::sendMail(
    //   $subject,
    //   CommentModel::templateEmail($subject, $_POST),
    //   FormNotificationModel::$recipients,
    // );

    return new WP_REST_Response([
      'response' => $commentResponse, 
      // 'mail_response' =>  $mailResponse
    ], $commentResponse['status']);
  }
}