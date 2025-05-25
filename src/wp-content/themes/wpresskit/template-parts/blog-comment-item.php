<?php
$title = $args['authorName'] ?? '';
$message = $args['message'] ?? '';
$date = $args['date'] ?? '';
?>

<div class="blog-details-comment mb-4">
  <!-- <div class="blog-details-comment-thumb">
    <img src="assets/images/inner-img/aouthor.png" alt="">
  </div> -->
  <!-- <div class="blog-details-comment-reply">							
    <a href="#">Reply</a>
  </div>	 -->
  <div class="blog-details-comment-content">							
    <?php if (empty(!$title)) { ?>
    <h2><?php echo $title; ?></h2>
    <?php } ?>
    
    <?php if (empty(!$date)) { ?>
    <span><?php echo convertDateToBrazil($date); ?></span>		
    <?php } ?>
    
    <?php if (empty(!$message)) { ?>
    <p><?php echo $message; ?></p>
    <?php } ?>
  </div>									
</div>