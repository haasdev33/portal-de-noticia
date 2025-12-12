# Portal de Notícias — Projeto

Este repositório contém um portal de notícias minimalista customizado. O foco principal do projeto é fornecer:

- Um painel administrativo simples para gerir conteúdo (artigos e páginas) com CRUD completo.
- Páginas dinâmicas configuráveis pelo admin que suportam componentes embutidos (shortcodes) como formulários, blocos de contato e mapas.
- Um sistema de `Settings` para armazenar informações do negócio (telefone, email, mapa, horários, redes sociais) que podem ser exibidas em páginas e no rodapé.
- Interface frontend responsiva baseada em Bootstrap com um layout de página reutilizável e componentes para blocos comuns.

## Principais funcionalidades

- **CRUD de Páginas via Admin**
	- Criar/Editar/Remover páginas em `/admin/pages`.
	- Campos especiais: `show_in_menu` (exibir no menu) e `hide_business_info` (ocultar seção de contato nessa página).

- **Shortcodes / Componentes de Página**
	- `[[contact_form]]` — insere o formulário de contato (envia para a rota `contact.send`).
	- `[[business_info]]` — exibe dados do `Settings` (email, telefone, endereço, horários).
	- `[[map]]` — renderiza o embed do mapa salvo em `Settings`.

- **Menu e Footer dinâmicos**
	- O menu principal e o footer listam automaticamente as páginas com `show_in_menu = true`.

- **Sistema de Settings**
	- Em `admin/settings` é possível configurar cores, logo, e informações do negócio (telefone, email, endereço, horário, mapa embed, redes sociais, FAQ de contato).

## Arquitetura e pontos técnicos

- `Page` (model): armazena `slug`, `title`, `content` e campos auxiliares (`thumbnail`, `video_url`, `show_in_menu`, `hide_business_info`).
- `Page::renderContent()` processa shortcodes básicos substituindo por partials Blade (components em `resources/views/page-components`).
- Rotas públicas:
	- A aplicação inclui uma rota fallback `/{slug}` que renderiza páginas pelo `slug` (última rota registrada para evitar conflitos com rotas explícitas).

## Como usar as páginas no Admin (exemplo rápido)

1. Acesse `/admin/pages` e clique em "Criar Página".
2. Preencha `slug` (ex: `ebook`), `title`, `content` e marque `Exibir no menu` para que apareça no nav.
3. Se quiser ocultar a seção de contato/empresa nessa página (ex.: landing de ebook), marque `Ocultar informações de contato`.
4. No conteúdo da página, use shortcodes conforme necessário (por exemplo coloque `[[contact_form]]` para mostrar formulário).

## Boas práticas e dicas de conteúdo

- Use `slug` curto e sem espaços (ex.: `ebook`, `about`).
- Para conteúdo complexo, combine HTML com os shortcodes; imagens enviadas via admin são salvas em `storage/pages`.
- Controle a visibilidade de páginas no menu com `show_in_menu` para evitar exibir páginas de teste.

## Arquivos chave (onde procurar funcionalidades)

- `app/Models/Page.php` — model e `renderContent()`.
- `app/Http/Controllers/AdminController.php` — lógicas de CRUD para páginas.
- `resources/views/page-components/` — partials: `contact_form`, `business_info`, `map`.
- `resources/views/layouts/app.blade.php` — header / menu / footer.
- `routes/web.php` — rotas públicas e admin.

## Publicar no GitHub

Se quiser publicar este projeto, basta commitar e subir para seu repositório remoto. Exemplo rápido:
```bash
git add .
git commit -m "Portal de Notícias - projeto"
git remote add origin git@github.com:SEU_USUARIO/portal-de-noticias.git
git push -u origin main
```

Se quiser, posso gerar um workflow GitHub Actions básico para rodar testes automaticamente no push.

Quer que eu ajuste alguma seção do README com exemplos reais do seu conteúdo (ex.: texto do ebook, imagens sugeridas, ou uma demo de shortcodes)?
