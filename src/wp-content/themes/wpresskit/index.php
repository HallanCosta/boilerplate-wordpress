<?php get_header(); ?>

<section class="home-section">
	<?php get_template_part('template-parts/logo', null); ?>
	<div class="box-invisible-normal"></div>
	
	<h1 class="title wow animate__animated animate__bounceInRight">WP APP</h1>
	
	<div class="box-invisible-normal"></div>
	<div class="col-4 ml-0">
		<?php get_template_part('template-parts/form', 'contact', []); ?>
	</div>

	<div class="box-invisible"></div>
	
	<h2>Selecione uma notícia</h2>
	<ul>
	<?php
		$posts = BlogModel::mountPosts(['limit' => -1]);

		foreach ($posts as $post) {
			echo '<li><a href="/blog/'.$post['permalink'].'">'.$post['title'].'</a></li>';
		}
	?>
	</ul>

	<div class="container">
		<div class="wpresskit-custom-owl-carousel owl-carousel owl-theme">
			<div class="col-lg-11">
				<img src="https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=400&txt_altura=400&extensao=png&fundo_r=0&fundo_g=0&fundo_b=0&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10" alt="">
			</div>
			<div class="col-lg-11">
				<img src="https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=400&txt_altura=400&extensao=png&fundo_r=1&fundo_g=0&fundo_b=0&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10" alt="">
			</div>
			<div class="col-lg-11">
				<img src="https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=400&txt_altura=400&extensao=png&fundo_r=1&fundo_g=0&fundo_b=0.9568627450980393&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10" alt="">
			</div>
			<div class="col-lg-11">
				<img src="https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=400&txt_altura=400&extensao=png&fundo_r=0.24609386920928955&fundo_g=0&fundo_b=1&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10" alt="">
			</div>
			<div class="col-lg-11">
				<img src="https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=400&txt_altura=400&extensao=png&fundo_r=0&fundo_g=1&fundo_b=0.5568627450980392&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10" alt="">
			</div>
			<div class="col-lg-11">
				<img src="https://www.4devs.com.br/4devs_gerador_imagem.php?acao=gerar_imagem&txt_largura=400&txt_altura=400&extensao=png&fundo_r=0.30109413371732074&fundo_g=0&fundo_b=0.5709635615348816&texto_r=0&texto_g=0&texto_b=0&texto=&tamanho_fonte=10" alt="">
			</div>
		</div>
	</div>

	<!-- <div class="container">
		<div class="row">
			<div class="wp-owl-carousel">
				
			</div>
		</div>
	</div> -->
</section>

<script type="text/javascript">
  $$page = "home";
</script>

<?php get_footer(); ?>