<?php 
class EmailService {
  public static function sendMail($subject, $body, $recipients) {
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    
    $response = wp_mail(
      $recipients,
      $subject,
      $body,
      $headers
    );

    return $response;
  }
}