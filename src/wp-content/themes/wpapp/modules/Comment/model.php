<?php
/**
 * Install plugin rwmb metabox
 */

class CommentModel {
  public static $cptNameSingular = 'comment';
  public static $cptNamePlural = 'comments';
  public static $cptLabelSingular = 'Comment';
  public static $cptLabelPlural = 'Comments';

  public static $postType; 
  public static $out = [];

  public static function run() {
    self::$postType = self::$cptNameSingular;
  }

  public static function isValidFields($data) {
    if (
      !check_email($data['email'])
      // empty($date['message']) ||
      // empty($date['authorName']) ||
      // empty($date['authorWebsite']) ||
      // empty($date['postId'])
    ) {
      self::$out["staus"] = 400;
      self::$out["message"] = "Dados do formulários inválidos!";
      self::$out["data"] = $data;
      return false;
    }

    return true;
  }


  public static function templateEmail($subject, $data) {    
    $datetime = formatDateTime('now', 'Y-m-d H:i:s');
    $datetime_fmt = date('d/m/Y H:i', strtotime($datetime));

    $name = $data['name'];
    $email = $data['email'];
    $whatsapp = $data['whatsapp'];
    $cnpj = $data['cnpj'];
    $state = $data['state'];
    $zipcode = $data['zipcode'];
    $message = $data['message'];

    return "
    <html>
      <body style='background-color: #f8f8f8; font-family: Arial, sans-serif; font-size: 16px; line-height: 1.5;'>
          <table style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #fff;'>
              <tbody>
                  <tr>
                    <td style='display: block; padding: 25px; gap: 20px;'>
                      <h1 style='text-align: center; font-size: 34px; color: #e8534a; font-weight: 700;'>$subject - Contato</h1>
                      <p style='text-align: justify; margin: 15px auto; text-align: center; max-width: 235px;'>Chegou uma mensagem atrav&eacute;s do site $subject!</p>
                      <ul>
                        <li>Data: $datetime_fmt</li>
                        <li>Nome: $name</li>
                        <li>Email: $email</li>
                        <li>Whatsapp: $whatsapp</li>
                        <li>CNPJ: $cnpj</li>
                        <li>Estado: $state</li>
                        <li>CEP: $zipcode</li>
                        <li>Mensagem: $message</li>
                      </ul>
                    </td>
                  </tr>
              </tbody>
          </table>
      </body>
    </html>
    ";
  }

  public static function statusCount($postId) {
    return get_comment_count($postId);
  }

  public static function save($data) {
    if (!self::isValidFields($data)) {
      return false;
    }

    $postId = intval($data['postId']);
    $authorName = isset($data['authorName']) ? trim($data["authorName"]) : '';
    $email = isset($data['email']) ? trim($data["email"]) : '';
    $authorWebsite = isset($data['authorWebsite']) ? trim($data["authorWebsite"]) : '';
    $message = isset($data['message']) ? trim($data["message"]) : '';

    // Dados do comentário
    $commentArgs = [
      'comment_post_ID' => $postId, // ID do post
      'comment_author' => $authorName,   // Nome do autor
      'comment_author_email' => $email, // E-mail do autor
      'comment_author_url' => $authorWebsite,  // URL do site (opcional)
      'comment_content' => $message, // Conteúdo do comentário
      'comment_type' => '',          // Tipo de comentário (deixe vazio para comentários normais)
      'comment_parent' => 0,         // Comentário pai (0 para comentários principais)
      'user_id' => 0,                // ID do usuário (0 para visitantes)
      'comment_approved' => 1,       // Aprovação automática (1 para aprovado, 0 para pendente)
    ];

    // Insere o comentário
    $commentId = wp_insert_comment($commentArgs);

    if (!$commentId) {
      self::$out["status"] = 400;
      self::$out["message"] = "Ocorreu um erro ao enviar o seu comentário!";
      return false;
    }

    self::$out["status"] = 201;
    self::$out["message"] = "Comentário enviada com sucesso!";
    // self::$out["recipients"] = FormNotificationModel::$recipients;
    self::$out["data"] = $data;

    return self::$out;
  }
}