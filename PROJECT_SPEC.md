# SOS-Estudante - Especificação Técnica e de Arquitetura

## 1. Visão Geral
O **SOS-Estudante** é uma aplicação web focada na organização da rotina acadêmica, gestão de tarefas, prazos, disciplinas, grade horária e anotações, dotada de um sistema robusto de auditoria e segurança.

## 2. Padrões de Arquitetura
O sistema segue uma arquitetura multicamadas inspirada no padrão MVC / Service Layer:

- **Camada de Configuração (`config/`)**:
  - `bd.php`: Singleton PDO com suporte a MySQL e fallback inteligente para SQLite.
  - `app.php`: Gestão de sessões nativas, helpers CSRF, funções flash (Toast), logs operacionais.
- **Camada de Modelos (`models/`)**:
  - `User.php`: Consultas e persistência de dados de usuários.
  - `Subject.php`: Gestão de disciplinas com contagem dinâmica de tarefas pendentes.
  - `Task.php`: Gestão de atividades acadêmicas com filtros múltiplos, status e ordenação.
  - `Schedule.php`: Gestão da grade horária semanal de aulas.
  - `Note.php`: Gestão de anotações com suporte a fixação (`is_pinned`).
  - `AuditLog.php`: Histórico imutável de operações de auditoria (Seção 3.3).
- **Camada de Regras de Negócio (`services/`)**:
  - `AuthService.php`: Criptografia com `password_hash()`, verificação com `password_verify()`, regeneração de ID de sessão e logs de auditoria.
  - `TaskService.php`, `SubjectService.php`, `ScheduleService.php`, `NoteService.php`: Validações de domínio e disparo automático de eventos de auditoria.
- **Camada de Interceptadores (`middlewares/`)**:
  - `AuthMiddleware.php`: Controle de acesso a páginas privadas.
  - `GuestMiddleware.php`: Redirecionamento de usuários já autenticados.
  - `CsrfMiddleware.php`: Validação estrita de tokens CSRF em todas as requisições `POST`.
- **Camada de Controladores (`controllers/`)**:
  - `AuthController.php`, `DashboardController.php`, `TaskController.php`, `SubjectController.php`, `ScheduleController.php`, `NoteController.php`, `HistoryController.php`.
- **Camada de Apresentação (`views/` & `assets/`)**:
  - Renderização estruturada em PHP com Mobile-First Tailwind CSS.
  - Notificações Toast para sucessos e erros (`assets/js/main.js`).
  - Modais de confirmação customizados (sem `alert()` ou `confirm()` nativos).

## 3. Segurança e Auditoria
1. **Proteção SQL**: 100% das consultas utilizam `PDO::prepare()` com binding seguro de parâmetros.
2. **Proteção CSRF**: Tokens criptográficos gerados por sessão e validados via middleware.
3. **Senhas**: Hashes seguros via `PASSWORD_DEFAULT` (Bcrypt/Argon2). Nenhuma senha é gravada em logs ou histórico.
4. **Auditoria (Seção 3.3)**: Registros de criação, edição, exclusão, conclusão, reabertura e logins/logouts com salvamento de estados anteriores e posteriores em JSON.
