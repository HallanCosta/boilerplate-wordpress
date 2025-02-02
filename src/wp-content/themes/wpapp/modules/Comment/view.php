<?php 

class CommentView {
  public static function getComments($args) {
    $postComments = get_comments($args);

    $comments = [];

    foreach ($postComments as $postComment) {
      $comments[] = [
        'id' => $postComment->comment_ID,
        'authorWebsite' => $postComment->comment_author_url,
        'authorName' => $postComment->comment_author,
        'email' => $postComment->comment_author_email,
        'message' => $postComment->comment_content,
        'date' => $postComment->comment_date,
        'postId' => $postComment->comment_post_ID,
      ];
    }

    return $comments;
  }

  public static function totalCount($postId) {
    $statusCount = CommentModel::statusCount($postId);
    return $statusCount['approved'];
  } 
}