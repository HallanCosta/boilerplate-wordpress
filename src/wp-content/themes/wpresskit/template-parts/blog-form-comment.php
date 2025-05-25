<section class="form-comment-section">
  <div class="title">
    <h3>Comentários da Notícia</h3>
    <p>Seu endereço de e-mail não será publicado. Então, não se preocupe</p>
    <span></span>
  </div>
  <form method="POST" id="form-comment" class="form-comment">
    <input type="hidden" id="postId" name="postId" value="1">

    <div class="row">
      <div class="col-md-12">
        <textarea name="message" class="mb-20" id="comment-msg-box" cols="30" rows="4" placeholder="Digite um comentário"></textarea>
        <span class="message-error hidden mb-2">Campo inválido</span>
        <div class="box-invisible-small"></div>
      </div>
      <div class="col-md-6">
        <input type="text" id="authorName" name="authorName" placeholder="Nome e Sobrenome">
        <span class="message-error hidden mb-2">Campo inválido</span>
        <div class="box-invisible-small"></div>
      </div>
      
      <div class="col-md-6">
        <input type="text" id="email" name="email" placeholder="Email">
        <span class="message-error hidden mb-2">Campo inválido</span>
        <div class="box-invisible-small"></div>
      </div>

      <div class="col-lg-12">
        <input type="text" id="authorWebsite" name="authorWebsite" placeholder="Seu site">
        <span class="message-error hidden mb-2">Campo inválido</span>
        <div class="box-invisible-small"></div>
      </div>									
      <div class="col-lg-12">
        <button type="submit" class="submit-comment">Enviar Comentário</button>
      </div>
    </div>
  </form>
</section>