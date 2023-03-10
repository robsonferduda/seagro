 <!-- ======= Contact Us Section ======= -->
 <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Contato</h2>
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
                <select class="form-select" aria-label="Default select example">
                  <option selected>Destino</option>
                  <option value="adm">Setor Administrativo</option>
                  <option value="financeiro">Setor Financeiro</option>
                  <option value="cadastro">Setor de Cadastro</option>
                  <option value="comunicacao">Setor de Comunicação</option>
                </select>
              </div>
              <div class="col-lg-6 form-group">
                <input type="text" name="nome" class="form-control" id="nome" value="{{ old("nome") }}" placeholder="Nome" required>
              </div>
              <div class="col-lg-6 form-group">
                <input type="email" class="form-control" name="email" id="email" value="{{ old("email") }}" placeholder="Email" required>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 form-group">
                <input type="text" class="form-control" name="celular" id="celular" value="{{ old("celular") }}" placeholder="Celular" required>
              </div>
              <div class="col-lg-6 form-group">
                <input type="text" class="form-control" name="fixo" id="fixo" value="{{ old("fixo") }}" placeholder="Telefone Fixo">
              </div>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="message" rows="5" placeholder="Mensagem" value="{{ old("message") }}" required></textarea>
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