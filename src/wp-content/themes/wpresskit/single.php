<?php get_header(); ?>

<?php
$postId = get_the_ID();
?>

<section class="single-post">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?php 
          $comments = CommentView::getComments([
            'post_id' => $postId,
            'status' => 'approve'
          ]); 

          foreach ($comments as $comment) {
            get_template_part('template-parts/blog', 'comment-item', $comment); 
          } 
        ?>
      </div>

      <a id="btn-loading-comments" href="javascript:void();" class="text-end">Ver Mais</a>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="box-invisible-normal"></div>
        <?php get_template_part('template-parts/blog', 'form-comment', []); ?>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  $$page = "noticia";
</script>

<?php get_footer(); ?>