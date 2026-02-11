# Sistema de Oportunidades - SEAGRO

## Descrição
Sistema completo de gerenciamento de oportunidades de emprego, estágio e freelance para o site do SEAGRO-SC.

## Funcionalidades Implementadas

### 1. Gerenciamento Administrativo
- **Criar Oportunidades**: Formulário completo com todos os campos necessários
- **Editar Oportunidades**: Atualização de informações com manutenção opcional de arquivos
- **Excluir Oportunidades**: Remoção com deleção de arquivos físicos
- **Ativar/Desativar**: Toggle rápido de status de publicação
- **Listagem**: DataTable com filtros e ordenação

### 2. Exibição Pública
- **Listagem de Oportunidades**: Cards com informações resumidas
- **Detalhes da Oportunidade**: Página completa com todas as informações
- **Contador de Visualizações**: Incremento automático ao visualizar
- **Compartilhamento Social**: Botões para Facebook, Twitter e WhatsApp
- **Validação de Prazo**: Indicação visual de vagas expiradas

## Campos do Sistema

### Campos Obrigatórios
- **Título**: Nome da vaga (3-255 caracteres)
- **Descrição**: Detalhes completos da oportunidade
- **Empresa**: Nome da empresa contratante
- **Tipo**: Emprego, Estágio ou Freelance
- **Localização**: Cidade/Estado da vaga
- **Data de Publicação**: Data de início da divulgação

### Campos Opcionais
- **Faixa Salarial**: Valor ou faixa de remuneração
- **Válida Até**: Data de expiração da vaga
- **Link Externo**: URL para candidatura externa
- **Arquivo**: Anexo PDF/DOC/DOCX (máx. 5MB)
- **Ativo**: Status de publicação (padrão: Sim)

## Estrutura de Arquivos Criados/Modificados

### Models
- `app/Models/Oportunidade.php` - Model com SoftDeletes e scopes

### Controllers
- `app/Http/Controllers/OportunidadeController.php` - CRUD completo

### Requests (Validação)
- `app/Http/Requests/OportunidadeRequest.php` - Regras de validação

### Views Administrativas
- `resources/views/gercont/oportunidades.blade.php` - Listagem admin
- `resources/views/oportunidades/create.blade.php` - Formulário de criação
- `resources/views/oportunidades/edit.blade.php` - Formulário de edição

### Views Públicas
- `resources/views/oportunidades/index.blade.php` - Listagem pública
- `resources/views/oportunidades/detalhes.blade.php` - Página de detalhes

### Rotas
Adicionadas em `routes/web.php`:
```php
// Rotas públicas
Route::get('oportunidades','OportunidadeController@index');
Route::get('oportunidades/show/{id}','OportunidadeController@show');

// Rotas administrativas (protegidas por auth)
Route::get('gercont/oportunidades','OportunidadeController@lista');
Route::get('oportunidades/create','OportunidadeController@create');
Route::get('oportunidades/atualizar/{id}','OportunidadeController@atualizar');
Route::resource('oportunidade','OportunidadeController')->except(['show', 'create']);
```

### Database
- `database/sql/create_table_oportunidade.sql` - Script SQL para criação da tabela

### Storage
- `public/oportunidades/` - Diretório para arquivos anexos

## Instalação

### 1. Criar Tabela no Banco de Dados
Execute o SQL localizado em `database/sql/create_table_oportunidade.sql`:

```bash
mysql -u seu_usuario -p u238873253_site < database/sql/create_table_oportunidade.sql
```

Ou acesse o phpMyAdmin e execute o conteúdo do arquivo.

### 2. Verificar Permissões
Certifique-se de que o diretório de uploads tem permissões adequadas:

```bash
chmod 775 public/oportunidades
```

## Uso

### Acessar Gerenciamento
1. Faça login no sistema administrativo
2. Acesse: `http://seusite.com/gercont/oportunidades`
3. Clique em "Cadastrar" para criar nova oportunidade

### Visualizar Publicamente
- Listagem: `http://seusite.com/oportunidades`
- Detalhes: `http://seusite.com/oportunidades/show/{id}`

## Funcionalidades Especiais

### Scope Ativas
O model possui um scope que filtra automaticamente oportunidades:
- Com `fl_ativo = 1`
- Sem `dt_validade` OU com `dt_validade` maior ou igual à data atual

```php
$oportunidades = Oportunidade::ativas()->get();
```

### Método isValida()
Verifica se a oportunidade ainda está dentro do prazo:

```php
if ($oportunidade->isValida()) {
    // Vaga ainda válida
}
```

### Upload de Arquivos
- Formato automático: `oportunidade-{timestamp}.{extensão}`
- Armazenamento: `public/oportunidades/`
- Tipos aceitos: PDF, DOC, DOCX
- Tamanho máximo: 5MB

### Validação de Datas
- Formato: dd/mm/yyyy
- `dt_validade` deve ser posterior a `dt_publicacao`

## Segurança
- Rotas administrativas protegidas por middleware `auth`
- Validação de formulários via FormRequest
- Sanitização de uploads de arquivos
- SoftDeletes para recuperação de dados

## Próximos Passos Sugeridos
1. Adicionar sistema de inscrição interna (formulário de candidatura)
2. Implementar notificações por email para novas oportunidades
3. Criar painel de estatísticas (visualizações, candidaturas)
4. Adicionar filtros avançados na listagem pública (tipo, localização, salário)
5. Sistema de tags/categorias para melhor organização

## Observações
- O sistema segue os mesmos padrões de Boletins e Eventos já implementados
- As views utilizam Bootstrap para responsividade
- Integração com SweetAlert2 para confirmações
- DataTables para listagens administrativas
