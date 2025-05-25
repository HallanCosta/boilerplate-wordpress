<?php 
class FormController extends WP_REST_Controller {
  public $formModel;
  
  public function __construct($formModel) {
    $this->formModel = $formModel;
  }

  public static function createInstance($formModel) {
    return new self($formModel);
  }

  public function registerRoutes() {
    register_rest_route('wpresskit/v1', $this->formModel->route, [
      'methods' => 'POST',
      'callback' => function() {
        return FormController::save($this->formModel->data);
      },
    ]);
  }

  public function save($data) {
    if (!function_exists('rwmb_set_meta')) {
      return new WP_REST_Response([
        'errpr' => 'Instale o plugin RWMB Meta Box para salvar os dados do formulário',
      ], 501);
    } 
  
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