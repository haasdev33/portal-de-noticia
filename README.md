📰 Portal de Notícias — Laravel CMS Minimalista

Um portal de notícias minimalista desenvolvido em Laravel, com páginas totalmente editáveis, shortcodes, menu dinâmico, footer automatizado e painel administrativo simples para gerenciamento de conteúdo.

O projeto foi criado para quem precisa de um CMS leve, fácil de personalizar e com estrutura clara para evoluir.

✨ Recursos principais
📝 Páginas dinâmicas com CRUD completo

Criar, editar e excluir páginas via /admin/pages

Campos especiais:

show_in_menu → Exibir no menu principal

hide_business_info → Ocultar seção de informações da empresa na página

Upload de thumbnail, vídeo e conteúdo em HTML/RichText

🧩 Shortcodes embutidos

O conteúdo das páginas suporta blocos dinâmicos via shortcodes:

Shortcode	Função
[[contact_form]]	Exibe o formulário de contato
[[business_info]]	Informações do negócio configuráveis no admin
[[map]]	Mapa embed configurado no painel
⚙️ Sistema de Settings (Configurações globais)

Em /admin/settings é possível configurar:

Email, telefone, endereço

Cores do site e logo

Horários de funcionamento

Embed do Google Maps

Redes sociais

FAQs e blocos de contato

🧭 Menu e Footer automáticos

O menu principal lista páginas com show_in_menu = true

Footer renderiza informações do Settings + páginas relevantes

📦 Arquitetura simples e extensível

Page model central para renderizar conteúdo

Rotas públicas automáticas via fallback: /{slug}

Componentes Blade organizados em resources/views/page-components/

🚀 Instalação
1️⃣ Clonar o repositório
git clone https://github.com/haasdev33/portal-de-noticia.git
cd portal-de-noticia

2️⃣ Instalar dependências
composer install
npm install && npm run build

3️⃣ Configurar o .env
cp .env.example .env
php artisan key:generate


Configurar banco de dados:

DB_DATABASE=portal
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Migrar tabelas
php artisan migrate --seed


O seed cria um admin padrão:

Email: admin@example.com

Senha: password
(Edite conforme necessário no DatabaseSeeder)

5️⃣ Ativar storage
php artisan storage:link

6️⃣ Iniciar o servidor
php artisan serve

🗂️ Estrutura — Pastas e arquivos importantes
Arquivo/Pasta	Função
app/Models/Page.php	Model de página e sistema de shortcodes
app/Http/Controllers/AdminController.php	Gerenciamento de páginas e settings
resources/views/layouts/app.blade.php	Layout principal (menu e footer dinâmicos)
resources/views/page-components/	Partials dos shortcodes
routes/web.php	Rotas públicas + fallback para páginas
🧩 Como usar páginas no Admin

Acesse /admin/pages

Clique em Criar Página

Preencha:

slug (ex.: sobre, ebook, noticias)

title

content (HTML + shortcodes)

Marque:

Exibir no menu → adiciona ao menu automático

Ocultar informações da empresa → remove bloco de contato

Salve e acesse no navegador:

/{slug}

🔧 Como usar os Shortcodes

Dentro do editor de conteúdo:

Formulário de contato
[[contact_form]]

Dados da empresa (settings)
[[business_info]]

Mapa configurável
[[map]]


Eles serão automaticamente substituídos por componentes Blade.

🛠️ Personalização
Modificar layout

Edite:

resources/views/layouts/app.blade.php

Criar novos componentes de shortcode

Crie um Blade em:

resources/views/page-components/novo_componente.blade.php


E adicione suporte em Page::renderContent().

🔒 Autenticação e painel admin

O painel fica em:

/admin


Com autenticação padrão do Laravel.

A partir daqui você consegue gerenciar:

Páginas

Configurações

Conteúdos dinâmicos

📸 Screenshots (opcional)

Recomendo adicionar prints como:

Painel admin

Página de criação de conteúdo

Exemplo de shortcode funcionando

Layout frontend

Você pode adicionar assim:

![Admin](screenshots/admin.png)

🤝 Contribuição

Pull requests são bem-vindos.
Siga este fluxo:

Crie uma branch:

git checkout -b feature/minha-feature


Commit:

git commit -m "Adiciona nova feature"


Push:

git push origin feature/minha-feature


Abra um PR no GitHub.
