 <!-- ======= Contact Us Section ======= -->
 <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2 class="title">Contato</h2>
      </div>

      <div class="row">

        <div class="col-lg-6 d-flex" data-aos="fade-up">
          <div class="info-box">
            <i class="bx bx-map"></i>
            <h3>Endereço</h3>
            <p>Rua Adolfo Melo, 35 - Centro Executivo Via Veneto - Sala 1002
            </p>
            <p> Florianópolis/SC - Centro - CEP: 88015-090</p>
          </div>
        </div>

        <div class="col-lg-3 d-flex" data-aos="fade-up" data-aos-delay="100">
          <div class="info-box">
            <i class="bx bx-envelope"></i>
            <h3>Email</h3>
            <p>seagro@seagro-sc.org.br</p>
          </div>
        </div>

        <div class="col-lg-3 d-flex" data-aos="fade-up" data-aos-delay="200">
          <div class="info-box ">
            <i class="bx bx-phone-call"></i>
            <h3>Telefone</h3>
            <p>(48) 3224-5681</p>
          </div>
        </div>

        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="300">
          <form action="{{ url('email/contato') }}" method="post" role="form" class="php-email-form">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <div class="row">
              <div class="col-lg-12 form-group">
                <label>Destino</label>
                <select name="destino" class="form-select" required>
                  <option value="" selected>Selecione um setor</option>
                  <option value="secretaria">Secretaria</option>
                  <option value="cadastro">Setor de Cadastro</option>
                </select>
              </div>
              <div class="col-lg-6 form-group">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" value="{{ old("nome") }}" placeholder="Nome" required>
              </div>
              <div class="col-lg-6 form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old("email") }}" placeholder="Email" required>
              </div>
            </div>
            <div class="row my-0">
              <div class="col-lg-6 form-group">
                <label>Telefone Celular <span class="text-primary">Digite somente números</span></label>
                <input type="text" class="form-control" name="celular" id="celular" value="{{ old("celular") }}" placeholder="(99) 99999-9999" required>
              </div>
              <div class="col-lg-6 form-group">
                <label>Telefone Fixo <span class="text-primary">Digite somente números</span></label>
                <input type="text" class="form-control" name="fixo" id="fixo" value="{{ old("fixo") }}" placeholder="(99) 9999-9999">
              </div>
            </div>
            <div class="row mt-1">
              <div class="form-group">
                <label>Mensagem</label>
                <textarea class="form-control" name="message" rows="5" placeholder="Mensagem" value="{{ old("message") }}" required></textarea>
              </div>
            </div>
            <div class="my-3">
              <div class="loading">Carregando</div>
              <div class="error-message"></div>
              <div class="sent-message">Sua mensagem foi enviada com sucesso, obrigado!</div>
            </div>
            <div class="text-center"><button type="submit">Enviar</button></div>
          </form>
        </div>
      </div>
    </div>
  </section>