# SOS-Estudante 🎓

> Sistema web de organização acadêmica desenvolvido em PHP estruturado, MySQL com PDO e Tailwind CSS, projetado de acordo com as diretrizes do `requisitos.md`.

---

## 🌟 Funcionalidades Principais

- **Autenticação Segura & Gestão de Usuários**:
  - Cadastro, login seguro e encerramento de sessão.
  - Criptografia com `password_hash()` e `password_verify()`.
  - Proteção contra Session Fixation (`session_regenerate_id()`) e proteção contra ataques CSRF em todos os formulários.
  - Painel de perfil para atualização de dados acadêmicos e alteração de senha.

- **Painel Geral (Dashboard)**:
  - Métricas de tarefas pendentes, concluídas, de alta prioridade e total de disciplinas.
  - Barra de progresso da conclusão acadêmica.
  - Listagem de próximas entregas com botão rápido de conclusão.
  - Grade de aulas do dia.
  - Lembretes rápidos fixados e histórico de operações recentes.

- **Tarefas e Atividades Acadêmicas**:
  - CRUD completo para trabalhos, provas, exercícios, leituras e projetos.
  - Filtros dinâmicos por status (Pendente, Em Andamento, Concluída), prioridade (Baixa, Média, Alta, Urgente), tipo de atividade e disciplina.
  - Busca textual em tempo real.
  - Alternância rápida de status de conclusão.

- **Disciplinas & Matérias**:
  - Cadastro e edição com cores personalizadas de identificação visual.
  - Professor responsável e sala/link.
  - Contador de atividades pendentes vinculadas.

- **Grade Horária Semanal**:
  - Visualização de horários de Segunda a Domingo.
  - Destaque automático para o dia da semana atual ("Hoje").

- **Anotações Rápidas & Lembretes**:
  - Resumos rápidos com capacidade de fixar lembretes importantes no topo.
  - Busca textual em anotações.

- **Histórico & Auditoria (Requisitos Seção 3.3)**:
  - Registro imutável de todas as ações (`CREATE`, `UPDATE`, `DELETE`, `COMPLETE`, `LOGIN`, `LOGOUT`).
  - Salvamento de valores anteriores e posteriores em JSON.
  - Filtros por ação, módulo/entidade, data e busca textual.
  - Proteção de segurança: nunca armazena senhas ou tokens nos registros de auditoria.

- **Interface Mobile-First & Feedback ao Usuário**:
  - Totalmente responsivo com Tailwind CSS (smartphones, tablets e computadores).
  - Sistema de notificações **Toast** para mensagens de sucesso, alerta e erro.
  - **Modais customizados** para interações e confirmações de exclusão, sem caixas de diálogo nativas (`alert()`, `confirm()`).

---

## 📂 Estrutura do Projeto

```text
SOS-Estudante/
├── config/
│   ├── bd.php                  # Conexão PDO segura (MySQL / Fallback SQLite)
│   └── app.php                 # Sessão, CSRF, Toasts e utilitários
├── controllers/
│   ├── AuthController.php      # Login, cadastro, logout, perfil
│   ├── DashboardController.php # Painel e indicadores
│   ├── TaskController.php      # Gerenciamento de tarefas
│   ├── SubjectController.php   # Gerenciamento de matérias
│   ├── ScheduleController.php  # Grade horária
│   ├── NoteController.php      # Anotações e lembretes
│   └── HistoryController.php   # Auditoria e histórico de logs
├── services/
│   ├── AuthService.php         # Regras de autenticação e criptografia
│   ├── TaskService.php         # Regras e auditoria de tarefas
│   ├── SubjectService.php      # Regras de disciplinas
│   ├── ScheduleService.php     # Regras de grade horária
│   └── NoteService.php         # Regras de anotações
├── models/
│   ├── User.php                # Consultas à tabela users
│   ├── Subject.php             # Consultas à tabela subjects
│   ├── Task.php                # Consultas à tabela tasks
│   ├── Schedule.php            # Consultas à tabela schedules
│   ├── Note.php                # Consultas à tabela notes
│   └── AuditLog.php            # Consultas à tabela audit_logs
├── middlewares/
│   ├── AuthMiddleware.php      # Restringe acesso a usuários logados
│   ├── GuestMiddleware.php     # Redireciona visitantes já autenticados
│   └── CsrfMiddleware.php      # Proteção contra ataques CSRF
├── views/
│   ├── layouts/
│   │   ├── header.php          # Cabeçalho, sidebar desktop e drawer mobile
│   │   └── footer.php          # Rodapé e renderizador de Toasts
│   ├── auth/                   # Telas de login, registro e perfil
│   ├── dashboard/              # Painel do estudante
│   ├── tasks/                  # Telas de listagem, criação e edição de tarefas
│   ├── subjects/               # Listagem e modal de disciplinas
│   ├── schedule/               # Grade semanal
│   ├── notes/                  # Anotações e lembretes
│   ├── history/                # Histórico e auditoria
│   └── errors/                 # Páginas 404 e 500
├── assets/
│   ├── css/custom.css          # Estilos complementares e animações
│   └── js/main.js              # Sistema de Toasts e Modais sem alert/confirm
├── database/
│   ├── schema.sql              # Script MySQL com tabelas, chaves e índices
│   └── schema_sqlite.sql       # Script SQLite para testes e desenvolvimento local
├── routes/
│   ├── Router.php              # Roteador HTTP seguro
│   └── web.php                 # Definição das rotas
├── logs/
│   └── app.log                 # Log operacional protegido
├── storage/                    # Armazenamento interno
├── tests/
│   └── run_tests.php           # Suíte de testes automatizados
├── .env.example                # Variáveis de ambiente de exemplo
├── .gitignore                  # Arquivos ignorados pelo Git
├── PROJECT_SPEC.md             # Especificação técnica detalhada
├── requisitos.md               # Requisitos originais do projeto
└── index.php                   # Ponto de entrada da aplicação
```

---

## 🚀 Como Executar

### 1. Configuração do Banco de Dados
O sistema suporta tanto **MySQL** (padrão) quanto **SQLite** (útil para desenvolvimento ágil).

- **Opção A - MySQL (Recomendado para produção/XAMPP)**:
  1. Certifique-se de que o MySQL esteja ativo.
  2. Importe o arquivo `database/schema.sql` no seu banco de dados:
     ```sql
     mysql -u root -p < database/schema.sql
     ```
  3. No arquivo `.env`, configure suas credenciais:
     ```env
     DB_DRIVER=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_NAME=sos_estudante
     DB_USER=root
     DB_PASS=
     ```

- **Opção B - Fallback Automático SQLite**:
  Caso o MySQL não esteja em execução na máquina local, o sistema ativa automaticamente o SQLite em `storage/database.sqlite`, criando todas as tabelas necessárias de forma transparente.

### 2. Executar o Servidor PHP Local
No terminal (PowerShell ou Bash):
```bash
php -S localhost:8000
```
*(ou utilizando o executável em `php_bin/php.exe -S localhost:8000`)*

Abra seu navegador em:
👉 **`http://localhost:8000`**

### 3. Execução dos Testes Automatizados
Para rodar a suíte completa de testes de aceitação e regras de negócio:
```bash
php tests/run_tests.php
```

---

## 🔒 Segurança Implementada
- Conexões PDO com Prepared Statements contra SQL Injection.
- Senhas geradas com hash criptográfico `password_hash()`.
- Sessões protegidas com `HttpOnly`, `SameSite=Lax` e regeneração de ID pós-login.
- Proteção CSRF com tokens em todas as requisições `POST`.
- Logs de auditoria sanitizados (nenhuma credencial é exposta).
- Modais personalizados substituindo completamente caixas de diálogo nativas (`alert`, `confirm`).
