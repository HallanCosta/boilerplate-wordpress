
<div class="form-box">
	<div class="form-header">
		<h1>Preencha o formulário e entraremos em contato em breve.</h1>
	</div>

	<form id="form-contact">
		<div class="form-content">
			<div class="row">
				<div class="col-lg-6 mt-4">
					<input name="name" id="name" type="text" placeholder="Nome"> 
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>

				<div class="col-lg-6 mt-4">
					<input name="email" id="email" type="email" placeholder="E-mail">
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>

				<div class="col-lg-6 mt-4">
					<input class="cellphone-mask" name="whatsapp" id="whatsapp" type="text" placeholder="Whatsapp">
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>

				<div class="col-lg-6 mt-4">
					<input class="cnpj-mask" name="cnpj" id="cnpj" type="text" placeholder="CNPJ">
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>

				<div class="col-lg-6 mt-4">
					<select name="state" id="state">
						<option value="" selected disabled>Estado</option>
						<option value="São Paulo">São Paulo</option>
					</select>
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>


				<div class="col-lg-6 mt-4">
					<input class="zipcode-mask" name="zipcode" id="zipcode" type="text" placeholder="CEP">
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>

				<div class="col-lg-12 mt-4">
					<textarea name="message" id="message" type="text" placeholder="Mensagem"></textarea>
					<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
				</div>

				<div class="col-lg-12 mt-4">
					<label class="checkbox" for="policy">
						<input class="hidden" type="checkbox" name="policy" id="policy" policy>
						<div class="row">
							<div class="col-lg-12 d-flex align-items-center">
								<span class="checkmark"></span>
								<span class="text">Aceito os <a href="#" target="_blank">termos e condições</a> de uso dos meus dados </span>
							</div>
						</div>
						<span class="message-error text-danger mt-2 d-block hidden">* campo obrigatório</span>
					</label>
				</div>
			</div>
		</div>

		<div class="form-footer">  
				<div class="box-invisible-small"></div>
				<button id="btn-enviar" class="btn">Enviar</button>
		</div>
	</form>
</div>
