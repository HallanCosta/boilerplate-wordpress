<?php 

class BlogView {
  public $post;
  public static BlogModel $blogModel;

  /**
 * Exibe os itens do blog com base nos parâmetros fornecidos.
 *
 * Esta função utiliza `mountPosts` para obter os posts formatados e exibe cada post
 * usando o template `template-parts/blog-item.php`. Além disso, ela lida com a paginação
 * dos resultados.
 *
 * Os parâmetros aceitos são os mesmos de `mountPosts` e `getPosts`. Para detalhes sobre
 * os parâmetros, consulte a documentação de `getPosts`.
 *
 * @param array $args Um array associativo contendo os parâmetros para filtrar os posts.
 *                    Os parâmetros são os mesmos aceitos por `mountPosts` e `getPosts`.
 *                    Veja a documentação de `getPosts` para detalhes.
   *                  - 'itemsPerView' (int): Quantidade que deve mostrar em tela. Padrão: 3.
 *
 * @return string Retorna o HTML gerado para os itens do blog e a paginação.
 *
 * @see BlogModel::mountPosts() Para obter os posts formatados.
 * @see BlogModel::getPosts() Para detalhes sobre os parâmetros aceitos.
 */
  public static function showBlogItems($args) {
    ob_start(); // Inicia o buffer de saída

    $posts = BlogModel::mountPosts($args);

    if (count($posts) < 1) {
      echo "<h4 class='text-center'>Nenhuma notícia foi encontrada</h4>";
    }

    foreach ($posts as $post) {
      get_template_part('template-parts/blog', 'item', [
        ...$post,
        'src' => $post['srcMedium'],
        'itemsPerView' => $args['itemsPerView']
      ]); 
    }

    $limit = (int)$args['limit'];
    $big = 999999999; // número grande para substituir no link base

    $totalPosts = BlogModel::getTotalPosts();

    if (isset($args['categories'])) $totalPosts = BlogModel::getTotalPostsByCategories($args['categories']);
    if (isset($args['tags'])) $totalPosts = BlogModel::getTotalPostsByTags($args['tags']);
    if (isset($args['search'])) $totalPosts = BlogModel::getTotalPostsBySearch([$args['search']]);

    $totalPages = $totalPosts / $limit;

    // Configura os argumentos para a paginação
    $paginationLinks = paginate_links(array(
      'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
      'format'    => '?paged=%#%',
      'current'   => max(1, get_query_var('paged')),
      'total'     => $totalPages,
      'mid_size'  => 1,
      'prev_text' => '<i class="fas fa-arrow-left"></i>', // Ícone de seta esquerda
      'next_text' => '<i class="fas fa-arrow-right"></i>', // Ícone de seta direita
      'type'      => 'array', // Retorna os links como uma array
    ));

    get_template_part('template-parts/blog', 'pagination', [
      'pagination' => $paginationLinks
    ]);

    return ob_get_clean(); // Obtém a saída do buffer e armazena em uma variável
  }

  /**
   * Summary of showBlogSearchItems
   * @param array $args ['limit' => -1, 'search' => 'ola mundo' ]  
   * @return bool|string
   */
  public function showBlogSearchItems($args) {
    ob_start(); // Inicia o buffer de saída

    $posts = BlogModel::mountPosts($args);

    if (count($posts) < 1 || empty($args['search'])) {
      echo "<h4>Nenhuma notícia foi encontrada</h4>";
      return ob_get_clean(); // Obtém a saída do buffer e armazena em uma variável
    }

    foreach ($posts as $post) {
      get_template_part('template-parts/blog', 'search-item', $post);
    }

    return ob_get_clean(); // Obtém a saída do buffer e armazena em uma variável
  }

}