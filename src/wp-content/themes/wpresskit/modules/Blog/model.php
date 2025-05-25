<?php
/**
 * Install plugin rwmb metabox
 */

class BlogModel {
  private static $cptTitleSingular = 'Blog';
  private static $cptTitlePlural = 'Blogs';
  private static $cptNameSingular = 'post';
  private static $cptNamePlural = 'posts';
  private static $cptLabelSingular = 'Blog';
  private static $cptLabelPlural = 'Blogs';
  private static $cptAddNewItem = 'Adicionar nova notícia';
  private static $cptAllItems = 'Todas as notícias';
  private static $cptDescription = '';

  private static $postType;

  // public $recipients = [];
  public static $postsPerPage = -1;
  public static $out = [];

  public static function run() {
    self::$postType = self::$cptNameSingular;
    self::$postsPerPage = get_option('posts_per_page'); // Buscar do CMS
    // $this->recipients[] = 'hallan.costa1.backup@gmail.com'; // Fallback

    add_action('admin_menu', function() {
      self::editMenuLabels();
    });
    add_action('admin_head', function() {
      self::styles();
    });

    // Usado para funcionar 
    // Exemplo 1: /blog/categoria/eventos
    // Exemplo 2: /blog/tag/associados
    add_action('init',  function() {
      self::rewriteRulesCategory();
      self::rewriteRulesTag();
      self::rewriteRulesSearch();
    });
    add_filter('query_vars', function($vars) {
      return self::queryVars($vars);
    });
    add_action('template_redirect', function() {
      self::handleRedirectPage();
    });
  }

  private static function rewriteRulesSearch() {
    add_rewrite_rule(
      '^blog/pesquisa/([^/]+)/page/([0-9]+)/?$',
      'index.php?s=$matches[1]&paged=$matches[2]',
      'top'
    );

    add_rewrite_rule(
      '^blog/pesquisa/([^/]+)/?$',
      'index.php?s=$matches[1]',
      'top'
    );
  }

  private static function rewriteRulesCategory() {
    // Permalink da páginação usando o ascendente "blog" e o nome da página "blog-categoria" ficando "blog/blog-categoria"
    // pagename=blog/blog-tag 
     add_rewrite_rule(
      '^blog/categoria/([^/]+)/page/([0-9]+)/?$',
      'index.php?pagename=blog/blog-categoria&categoryName=$matches[1]&paged=$matches[2]',
      'top'
    );

    // Permalink usando o ascendente "blog" e o nome da página "blog-categoria" ficando "blog/blog-categoria"
    // pagename=blog/blog-categoria 
    add_rewrite_rule(
      '^blog/categoria/([^/]+)/?$',
      'index.php?pagename=blog/blog-categoria&categoryName=$matches[1]',
      'top'
    );
  }

  private static function rewriteRulesTag() {
    // Permalink da páginação usando o ascendente "blog" e o nome da página "blog-tag" ficando "blog/blog-tag"
    // pagename=blog/blog-tag 
    add_rewrite_rule(
      '^blog/tag/([^/]+)/page/([0-9]+)/?$',
      'index.php?pagename=blog/blog-tag&tagName=$matches[1]&paged=$matches[2]',
      'top'
    );

    // Permalink usando o ascendente "blog" e o nome da página "blog-tag" ficando "blog/blog-tag"
    // pagename=blog/blog-tag 
    add_rewrite_rule(
      '^blog/tag/([^/]+)/?$',
      'index.php?pagename=blog/blog-tag&tagName=$matches[1]',
      'top'
    );
  }

  private static function queryVars($vars) {
    $vars[] = 'categoryName'; // Adiciona 'categoryName' como variável de consulta
    $vars[] = 'tagName'; // Adiciona 'tagName' como variável de consulta
    // $vars[] = 's'; // Adiciona 'search' como variável de consulta
    return $vars;
  } 

  private static function handleRedirectPage() {
    if (is_page('blog/categoria') || is_page('blog/tag')) {
      $categoryName = get_query_var('categoryName');
      $tagName = get_query_var('tagName');
      // $paged = get_query_var('paged') ? get_query_var('paged') : 1;

      if (!$categoryName && !$tagName) wp_redirect('/blog');
    }
  }

  private static function editMenuLabels() {
    global $menu, $submenu;
    $menu[5][0] = 'Blog';

    $submenu['edit.php'][5][0] = self::$cptAllItems; // Muda "Todos os Posts" para "Todos os Blogs"
    $submenu['edit.php'][10][0] = self::$cptAddNewItem; // Muda "Adicionar Novo" para "Adicionar Blog"
    $submenu['edit.php'][16][0] = 'Tags de Blog'; // Muda "Tags" para "Tags de Blog"
  }

  /**
   * Styles dashboard wordpress
   */
  private static function styles() {
    global $post_type;
    
    if ($post_type == self::$postType) {
      ?>
      <style>
        /* Ocultar permalink */
        /* Ocultar Smartcrawl SEO */
        /* Ocultar SmartCrawl SEO */


        /* #edit-slug-box, */
        /* #wds-wds-meta-box,  */
        /* #wds_main_title_counter_result { display: none; } */
      </style>
      <?php
    }
  }

  /**
   * Frontend
   */

  public static function getTotalPosts() {
    return wp_count_posts()->publish;
  }

  public static function getTotalPostsByCategories($categories = ['sem-categoria']) {
    global $wpdb;

    // Prepara a consulta SQL
    $query = "
      SELECT COUNT(DISTINCT p.ID) 
      FROM {$wpdb->posts} p
      INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
      INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
      INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
      WHERE p.post_type = 'post'
      AND p.post_status = 'publish'
      AND tt.taxonomy = 'category'
      AND t.slug IN ('" . implode("','", $categories) . "')
    ";
    
    return $wpdb->get_var($query);
  }

  public static function getTotalPostsByTags($tags = ['sem-tag']) {
    global $wpdb;

    // Prepara a consulta SQL
    $query = "
      SELECT COUNT(DISTINCT p.ID) 
      FROM {$wpdb->posts} p
      INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
      INNER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
      INNER JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
      WHERE p.post_type = 'post'
      AND p.post_status = 'publish'
      AND tt.taxonomy = 'post_tag'
      AND t.slug IN ('" . implode("','", $tags) . "')
    ";
    
    return $wpdb->get_var($query);
  }
  public static function getTotalPostsBySearch($research = ['eventos']) {
    global $wpdb;

    // Monta a condição SQL para cada termo de pesquisa
    $conditions = [];
    foreach ($research as $term) {
        $like_term = '%' . $wpdb->esc_like($term) . '%';
        $conditions[] = $wpdb->prepare("(p.post_title LIKE %s OR p.post_content LIKE %s)", $like_term, $like_term);
    }

    // Junta todas as condições com OR
    $search_condition = implode(' OR ', $conditions);

    // Prepara a consulta SQL
    $query = "
      SELECT COUNT(DISTINCT p.ID)
      FROM {$wpdb->posts} p
      WHERE p.post_type = 'post'
      AND p.post_status = 'publish'
      AND ($search_condition)
    ";

    // Executa a consulta
    return $wpdb->get_var($query);
  }


  /**
   * Summary of getPosts
   * 
   * Esta função retorna uma lista de posts com base nos parâmetros fornecidos.
   * 
   * @param array $args Um array associativo contendo os parâmetros para filtrar os posts. 
   *                      As chaves possíveis são:
   *                      - 'limit' (int): Limita o número de posts retornados. Padrão: 1.
   *                      - 'id' (int): Filtra os posts pelo ID. Padrão: 0 (nenhum filtro por ID).
   *                      - 'offset' (int): Define o deslocamento inicial para a paginação. Padrão: 0.
   *                      - 'tags' (array): Filtra os posts por tags. Deve ser um array de tags. Padrão: [].
   *                      - 'categories' (array): Filtra os posts por categorias. Deve ser um array de categorias. Padrão: [].
   *                      - 'search' (string): Filtra os posts por uma palavra-chave de busca. Padrão: ''.
   *                      - 'excludePostsId' (array): Exclui posts específicos pelo ID. Deve ser um array de IDs. Padrão: [].
   * 
   * @return array Retorna um array de posts que correspondem aos critérios de filtro.
   */
  public static function getPosts($args) {
    $limit = isset($args['limit']) ? $args['limit'] : 1;
    $id = isset($args['id']) ? $args['id'] : 0;
    $offset = isset($args['offset']) ? $args['offset'] : 0;
    $tags = isset($args['tags']) ? $args['tags'] : [];
    $categories = isset($args['categories']) ? $args['categories'] : [];
    $search = isset($args['search']) ? $args['search'] : '';
    $excludePostsId = isset($args['excludePostsId']) ? $args['excludePostsId'] : [];

    $argsQuery = [
      'post_type' => self::$postType,
      'numberposts' => $limit,
      'offset' => $offset,
      'post__not_in' => $excludePostsId,
      'category_name' => implode(',', $categories),
      'tag' => implode(',', $tags),
      'p' => $id,
      's' => $search
    ];

    $posts = get_posts($argsQuery);

    return $posts;
  }

  /**
   * Monta os posts a partir dos dados brutos obtidos do WordPress.
   *
   * Esta função depende da função `getPosts` para buscar os dados brutos dos posts.
   * Ela formata e organiza os dados em uma estrutura mais útil, incluindo informações
   * como título, conteúdo, data formatada, categorias, tags e URLs das imagens.
   *
   * @param array $args Um array associativo contendo os parâmetros para filtrar os posts.
   *                      Os parâmetros são os mesmos aceitos por `getPosts`.
   *                      Veja a documentação de `getPosts` para detalhes.
   *
   * @return array Retorna um array de posts formatados, onde cada post é um array associativo
   *               contendo as seguintes chaves:
   *               - 'id' (int): ID do post.
   *               - 'date' (string): Data formatada no padrão "dia de mês de ano".
   *               - 'title' (string): Título do post.
   *               - 'excerpt' (string): Resumo do post.
   *               - 'content' (string): Conteúdo completo do post.
   *               - 'permalink' (string): Slug do post.
   *               - 'commentStatus' (string): Status dos comentários (aberto/fechado).
   *               - 'pingStatus' (string): Status dos pings (aberto/fechado).
   *               - 'categories' (array): Array de categorias associadas ao post.
   *               - 'tags' (array): Array de tags associadas ao post.
   *               - 'srcSmall' (string): URL da imagem pequena do post.
   *               - 'srcMedium' (string): URL da imagem média do post.
   *               - 'srcFull' (string): URL da imagem grande do post.
   *
   * @see BlogModel::getPosts() Para detalhes sobre os parâmetros aceitos.
   */

  public static function mountPosts($args) {
    $posts = BlogModel::getPosts($args);

    if (empty($posts)) return []; 

    $data = [];

    foreach ($posts as $key => $post) {
      $id = $post->ID;
      $title = $post->post_title;
      $excerpt = $post->post_excerpt;
      $content = $post->post_content;
      $permalink = $post->post_name;
      $commentStatus = $post->comment_status;
      $pingStatus = $post->ping_status;

      // Date
      $dateOrigin = explode(' ', $post->post_date)[0];
      $dateParts = explode('-', $dateOrigin);
      $year = $dateParts[0];
      $month = (int)$dateParts[1]; // Converte o mês para inteiro
      $day = (int)$dateParts[2]; // Converte o dia para inteiro
      $months = [
        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
        5 => 'Maio', 6 => 'Junho', 7 => 'julho', 8 => 'Agosto',
        9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
      ];
      $date = $day . ' de ' . $months[$month] . ' de ' . $year;

      // Category
      $categories = BlogModel::getCategoriesByPostId($id);

      // Tags
      $tags = BlogModel::getTagsByPostId($id);

      // Image
      $imageId = get_post_thumbnail_id($id);

      $imageUrlSmall = wp_get_attachment_image_src($imageId, 'sz-admin-thumb');
      $postImageSmall = isset($imageUrlSmall[0]) ? $imageUrlSmall[0] : 'https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=90&txt_altura=90&extensao=png&fundo_r=0&fundo_g=0&fundo_b=0&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10';
      
      // medium
      $imageUrlMedium = wp_get_attachment_image_src($imageId, 'blog-medium');
      $postImageMedium = isset($imageUrlMedium[0]) ? $imageUrlMedium[0] : 'https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=424&txt_altura=267&extensao=png&fundo_r=0&fundo_g=0&fundo_b=0&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10';

      // full
      $imageUrlFull = wp_get_attachment_image_src($imageId, 'full');
      $postImageFull = isset($imageUrlFull[0]) ? $imageUrlFull[0] : 'https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=1920&txt_altura=608&extensao=png&fundo_r=0&fundo_g=0&fundo_b=0&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10';
      
      $data[] = [
        'id' => $id, 
        'date' => $date, 
        'title' => $title, 
        'excerpt' => $excerpt, 
        'content' => $content, 
        'permalink' => $permalink, 
        'commentStatus' => $commentStatus, 
        'pingStatus' => $pingStatus, 
        'categories' => $categories, 
        'tags' => $tags, 
        'srcSmall' => $postImageSmall,
        'srcMedium' => $postImageMedium,
        'srcFull' => $postImageFull
      ];
    }

    return $data; 
  }

  public static function getCategoriesByPostId($postId) {
    $categoryPosts = get_the_category($postId);

    $categories = [];

    foreach ($categoryPosts as $category) {
      $categories[] = [
        'id' => $category->term_id,
        'name' => $category->name,
        'slug' => $category->slug,
        'description' => $category->description
      ];
    }

    return $categories;
  }

  public static function getTagsByPostId($postId) {
    if (!$postId) {
        return [];
    }

    $tagsPost = wp_get_post_tags($postId);

    $tags = [];
    foreach ($tagsPost as $tag) {
      $tags[] = [
        'id' => $tag->term_id,
        'name' => $tag->name,
        'slug' => $tag->slug,
        'description' => $tag->description
      ];
    }

    return $tags;
  }

  public static function getAllTags() {
    $tagsTerms = get_terms([
      'taxonomy' => 'post_tag', // Taxonomia para categorias
      'hide_empty' => false, // Inclui categorias vazias
      'orderby' => 'name', // Ordena pelo nome
      'order' => 'ASC', // Ordem crescente (A-Z)
    ]);

    if (empty($tagsTerms)) {
      return [];
    }

    $tags = [];
    foreach ($tagsTerms as $tagTerm) {
      $tags[] = [
        'id' => $tagTerm->term_id,
        'name' => $tagTerm->name,
        'slug' => $tagTerm->slug,
        'description' => $tagTerm->description,
      ];
    }

    return $tags;
  }

  public static function getAllCategories() {
    $categoriesTerms = get_terms([
      'taxonomy' => 'category', // Taxonomia para categorias
      'hide_empty' => false, // Inclui categorias vazias
      'orderby' => 'name', // Ordena pelo nome
      'order' => 'ASC', // Ordem crescente (A-Z)
    ]);

    if (empty($categoriesTerms)) {
      return [];
    }

    $categories = [];
    foreach ($categoriesTerms as $categoryTerm) {
      $categories[] = [
        'id' => $categoryTerm->term_id,
        'name' => $categoryTerm->name,
        'slug' => $categoryTerm->slug,
        'description' => $categoryTerm->description,
      ];
    }

    return $categories;
  }
}