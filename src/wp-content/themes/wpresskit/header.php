<?php 
    $postId = get_the_ID();

    $titleDefault = trim(get_bloginfo('name'));
    $descriptionDefault = trim(get_bloginfo('description'));
    $imageDefault = 'REAL_FAVICON_IMAGE';
    
    $metadata = [
        'title' => $titleDefault,
        'description' => $descriptionDefault
    ];

    if (is_plugin_active( 'smartcrawl-seo/wpmu-dev-seo.php' )) {
        $seoTitle = get_post_meta($postId , '_wds_title', true); // Smartcrawl SEO Title
        $seoDescription = get_post_meta($postId , '_wds_metadesc', true); // Smartcrawl SEO Site
        $seoPermalink = get_permalink($postId);
        $seoType = is_single() ? 'article' : 'website';

        // Facebook
        $seoOpengraph = get_post_meta($postId , '_wds_opengraph', true); // Smartcrawl SEO Facebook
        $seoOpengraphImageId = '';
        $seoOpengraphImageExist = '';
        $seoOpengraphImage = '';
        if (!empty($seoOpengraph)) {
            $seoOpengraphImageId = isset($seoOpengraph['images']) ? $seoOpengraph['images'][0] : null;
            $seoOpengraphImageExist = wp_get_attachment_image_url($seoOpengraphImageId, 'thumbnail');
            $seoOpengraphImage =  $seoOpengraphImageExist ? wp_get_attachment_image_url($seoOpengraphImageId, 'thumbnail') : 'URL_DEFAULT';
        }

        // Twitter
        $seoTwitter = get_post_meta($postId , '_wds_twitter', true); // Smartcrawl SEO Twitter
        $seoTwitterImageId = '';
        $seoTwitterImageExist = '';
        $seoTwitterImage = '';
        if (!empty($seoTwitter)) {
            $seoTwitterImageId = isset($seoTwitterImage['images']) ? $seoTwitterImage['images'][0] : null; // Smartcrawl SEO
            $seoTwitterImageExist = wp_get_attachment_image_url($seoTwitterImageId, 'thumbnail');
            $seoTwitterImage = $seoTwitterImageExist ? wp_get_attachment_image_url($seoTwitterImageId, 'thumbnail') : '';
        }
    }

    // Twitter Cards (summary_large_image)
    // Tamanho recomendado: 1200 x 628 pixels
    // Tamanho mínimo: 300 x 157 pixels
    //
    //
    // Open Graph (Facebook, LinkedIn, etc.)
    // Tamanho recomendado: 1200 x 630 pixels
    // Tamanho mínimo: 600 x 315 pixels
    $metadata = [
        'title' => !empty($seoTitle) ? $seoTitle : $titleDefault,
        'description' => !empty($seoDescription) ? $seoDescription : $descriptionDefault,
        'opengraph' => [
            'title' => !empty($seoOpengraph['title']) ? $seoOpengraph['title'] : $titleDefault,
            'description' => !empty($seoOpengraph['description']) ? $seoOpengraph['description'] : $descriptionDefault,
            'image' => !empty($seoOpengraphImage) ? $seoOpengraphImage : $imageDefault,
        ],
        'twitter' => [
            'title' => !empty($seoTwitter['title']) ? $seoTwitter['title'] : $titleDefault,
            'description' => !empty($seoTwitter['description']) ? $seoTwitter['description'] : $descriptionDefault,
            'image' => !empty($seoTwitterImage) ? $seoTwitterImage : $imageDefault,
        ],
        'permalink' => $seoPermalink,
        'type' => $seoType
    ];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<!--[if IE 7 ]>    <html lang="pt-BR" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="pt-BR" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="pt-BR" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="pt-BR" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Metadata -->
    <title><?php echo $metadata['title']; ?></title>
    <meta name="description" content="<?php echo $metadata['description']; ?>" />

    <!-- Opengraph -->
    <meta property="og:title" content="<?php echo $metadata['opengraph']['title']; ?>" />
    <meta property="og:description" content="<?php echo $metadata['opengraph']['description']; ?>" />
    <meta property="og:image" content="<?php echo $metadata['opengraph']['image']; ?>" />
    <meta property="og:url" content="<?php echo $metadata['permalink']; ?>" />
    <meta property="og:type" content="<?php echo $metadata['type']; ?>" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?php echo $metadata['twitter']['title']; ?>" />
    <meta name="twitter:description" content="<?php echo $metadata['twitter']['description']; ?>" />
    <meta name="twitter:image" content="<?php echo $metadata['twitter']['image']; ?>" />
    <meta name="twitter:url" content="<?php echo $metadata['permalink']; ?>" />

    <!-- CSS -->
    <link href="<?php echo getTheme('style.css', getAppVersion()); ?>" rel="stylesheet" media="all" />
</head>

<body>
