<?php 
class FormController extends WP_REST_Controller {
  public FormModel $formModel;
  
  public function __construct($formModel) {
    $this->formModel = $formModel;
  }

  public function registerRoutes() {
    register_rest_route('wp-base-camp', $this->formModel->route, [
      'methods' => 'POST',
      'callback' => function() {
        return $this->save($this->formModel->data);
      },
    ]);
  }

  public function save($data) {
    $saved = $this->formModel->save($data);
    
    if (!$saved) {
      return new WP_REST_Response([
        'response' => $this->formModel->out, 
        'mail_response' =>  false
      ], 400);
    } 

    $mailResponse = EmailService::sendMail(
      $this->formModel->emailSubject,
      $this->formModel->templateEmail($data),
      FormNotificationModel::$recipients
    );

    return new WP_REST_Response([
      'response' => $saved, 
      'mail_response' =>  $mailResponse
    ], $saved['status']);
  }
}