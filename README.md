# Ensino Sem Fronteiras - Sistema de Gestão Escolar

## 📌 Sobre o Projeto
O **Ensino Sem Fronteiras (ESF)** é um sistema web desenvolvido para auxiliar no gerenciamento de alunos, responsáveis e pagamentos em aulas de reforço escolar. A aplicação permite cadastrar, editar e excluir alunos e responsáveis, registrar pagamentos, acompanhar estatísticas e gerar relatórios financeiros.

## 🎯 Funcionalidades
✅ **Gerenciamento de Alunos**: Cadastro, edição, listagem e exclusão de alunos.
✅ **Gerenciamento de Responsáveis**: Cadastro, edição, vinculação de alunos e exclusão.
✅ **Controle Financeiro**: Registro de pagamentos com status (pago, pendente e atrasado).
✅ **Dashboard Interativo**: Exibição de estatísticas e gráficos dinâmicos.
✅ **Filtros de Pagamentos**: Separação por status e exibição detalhada.
✅ **Design Responsivo**: Interface moderna com Bootstrap e gráficos interativos via Chart.js.

## 🛠️ Tecnologias Utilizadas
- **PHP 8.2** (Back-end)
- **MySQL** (Banco de Dados)
- **Bootstrap 5.3** (Front-end)
- **Chart.js** (Gráficos interativos)
- **JavaScript (AJAX)** (Requisições assíncronas)

## ⚙️ Instalação e Configuração
### 1️⃣ Clone o repositório
```bash
git clone https://github.com/seuusuario/ensino-sem-fronteiras.git
```
### 2️⃣ Configure o Banco de Dados
1. Importe o arquivo `database.sql` no seu MySQL.
2. Atualize as credenciais no arquivo `config/conexao.php`:
```php
$host = 'localhost';
$dbname = 'reforco_escolar';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
```

### 3️⃣ Inicie o Servidor Local
Se estiver utilizando o XAMPP, inicie o Apache e MySQL e acesse:
```
http://localhost/ensino-sem-fronteiras/
```

## 📌 Estrutura do Projeto
```
📂 ensino-sem-fronteiras
 ├── 📂 config         # Configuração do banco de dados
 ├── 📂 views          # Páginas do sistema (dashboard, alunos, responsáveis, pagamentos)
 ├── 📂 actions        # Scripts de manipulação de dados (CRUD)
 ├── 📂 assets         # Arquivos CSS, JS e imagens
 ├── 📂 database       # Arquivo .sql para criação das tabelas
 ├── index.php        # Página inicial
 ├── README.md        # Documentação do projeto
```

## 📌 Melhorias Futuras
🔹 Sistema de Notificações para pagamentos vencidos 📅
🔹 Envio de e-mails automáticos para responsáveis ✉️
🔹 Exportação de relatórios em PDF 📄

## ✨ Contribuições
Fique à vontade para contribuir com melhorias! Basta abrir um **Pull Request** ou relatar issues no repositório.

## 📜 Licença
Este projeto está sob a licença MIT.

**🚀 Desenvolvido com 💙 para facilitar a gestão educacional!**