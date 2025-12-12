# 📰 Portal de Notícias — CMS Minimalista em Laravel

Um portal de notícias moderno e minimalista desenvolvido em **Laravel**, com **páginas dinâmicas**, **shortcodes**, **menu e footer automáticos** e um **painel administrativo simples** para gestão de conteúdo.

O projeto é ideal para sites institucionais, portais, landing pages com conteúdo editável ou qualquer aplicação que precise de um CMS leve e extensível.

---

## ✨ Recursos principais

### 📝 Páginas dinâmicas com CRUD completo
- Criar, editar e excluir páginas em `/admin/pages`
- Campos especiais:
  - `show_in_menu` → Exibir no menu principal
  - `hide_business_info` → Ocultar bloco de informações de contato
- Suporte a HTML e shortcodes

### 🧩 Shortcodes disponíveis
Shortcodes podem ser usados diretamente no conteúdo das páginas:

| Shortcode | Descrição |
|----------|-----------|
| `[[contact_form]]` | Exibe um formulário de contato funcional |
| `[[business_info]]` | Mostra informações do negócio definidas em Settings |
| `[[map]]` | Renderiza o mapa embed configurado no admin |

### ⚙️ Sistema de Settings (Configurações globais)
Gerenciado via `/admin/settings`, incluindo:
- Email, telefone e endereço
- Horário de funcionamento
- Redes sociais
- Logo e cores do site
- Embed do Google Maps
- FAQ e informações de contato

### 🧭 Menu e Footer automáticos
- O menu principal exibe páginas com `show_in_menu = true`
- O footer usa tanto páginas quanto informações dos Settings

---

## 🚀 Instalação

### 1️⃣ Clonar o repositório
```sh
git clone https://github.com/haasdev33/portal-de-noticia.git
cd portal-de-noticia
composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

DB_DATABASE=portal
DB_USERNAME=root
DB_PASSWORD=

Email: admin@example.com
Senha: password

php artisan storage:link

php artisan serve

