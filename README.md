# Collaboration API

A Laravel-based RESTful API for project collaboration and task management. This API enables teams to create projects, manage tasks, invite members, and collaborate effectively with role-based access control and email notifications.

## 🚀 Features

-   **User Authentication**: Secure registration, login, and logout using Laravel Sanctum
-   **Project Management**: Create, read, update, and delete projects
-   **Task Management**: Full CRUD operations for tasks with filtering capabilities
-   **Team Collaboration**: Invite members to projects with role-based permissions
-   **Role-Based Access Control**: Three roles - Owner, Admin, and Member
-   **Email Notifications**: Automated emails for task creation, updates, invitations, and welcome messages
-   **Task Filtering**: Filter tasks by priority (low/high) and status (pending/in_progress/completed)
-   **Authorization Policies**: Granular permissions using Laravel Policies
-   **Event-Driven Architecture**: Events and listeners for email notifications

## 🛠️ Tech Stack

-   **Framework**: Laravel 12.x
-   **PHP**: ^8.2
-   **Authentication**: Laravel Sanctum
-   **Database**: SQLite (default, can be configured for MySQL/PostgreSQL)
-   **Email**: Laravel Mail (with queue support)
-   **Monitoring**: Laravel Telescope
-   **Frontend Assets**: Vite with Tailwind CSS

## 📋 Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js and npm
-   SQLite (or MySQL/PostgreSQL)

## 🔧 Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd collab
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure database**

    - Update `.env` file with your database credentials
    - For SQLite, ensure `database/database.sqlite` exists:
        ```bash
        touch database/database.sqlite
        ```

6. **Run migrations**

    ```bash
    php artisan migrate
    ```

7. **Configure mail settings** (optional, for email notifications)

    - Update mail configuration in `.env`:
        ```
        MAIL_MAILER=smtp
        MAIL_HOST=your-smtp-host
        MAIL_PORT=587
        MAIL_USERNAME=your-email
        MAIL_PASSWORD=your-password
        MAIL_ENCRYPTION=tls
        MAIL_FROM_ADDRESS=noreply@example.com
        MAIL_FROM_NAME="${APP_NAME}"
        ```

8. **Start queue worker** (for email notifications)
    ```bash
    php artisan queue:work
    ```

## 🚀 Running the Application

### Development Mode

Run the development server with all services:

```bash
composer run dev
```

This command runs:

-   Laravel development server
-   Queue worker
-   Laravel Pail (logs)
-   Vite dev server

### Manual Start

```bash
# Start Laravel server
php artisan serve

# In another terminal, start queue worker
php artisan queue:work

# In another terminal, start Vite (if needed)
npm run dev
```

## 📚 API Endpoints

### Authentication

All authentication endpoints are prefixed with `/api/auth`

| Method | Endpoint             | Description         | Auth Required |
| ------ | -------------------- | ------------------- | ------------- |
| POST   | `/api/auth/register` | Register a new user | No            |
| POST   | `/api/auth/login`    | Login user          | No            |
| POST   | `/api/auth/logout`   | Logout user         | Yes           |

**Register Request:**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Login Request:**

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (Login/Register):**

```json
{
    "message": "Welcome Back To The Website",
    "User": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "Token": "1|..."
}
```

### Projects

All project endpoints require authentication. Use the token in the `Authorization` header:

```
Authorization: Bearer {token}
```

| Method    | Endpoint             | Description                    | Auth Required    |
| --------- | -------------------- | ------------------------------ | ---------------- |
| GET       | `/api/projects`      | Get all projects owned by user | Yes              |
| POST      | `/api/projects`      | Create a new project           | Yes              |
| GET       | `/api/projects/{id}` | Get a specific project         | Yes              |
| PUT/PATCH | `/api/projects/{id}` | Update a project               | Yes (Owner only) |
| DELETE    | `/api/projects/{id}` | Delete a project               | Yes (Owner only) |

**Create Project Request:**

```json
{
    "name": "My New Project"
}
```

**Update Member Role:**

```
POST /api/projects/{projectId}/members/{userId}/role
Content-Type: application/json

{
  "role": "admin"  // or "member"
}
```

### Tasks

| Method    | Endpoint                                              | Description                                         | Auth Required |
| --------- | ----------------------------------------------------- | --------------------------------------------------- | ------------- |
| GET       | `/api/tasks`                                          | Get all tasks                                       | Yes           |
| POST      | `/api/tasks`                                          | Create a new task                                   | Yes           |
| GET       | `/api/tasks/{id}`                                     | Get a specific task                                 | Yes           |
| PUT/PATCH | `/api/tasks/{id}`                                     | Update a task                                       | Yes           |
| DELETE    | `/api/tasks/{id}`                                     | Delete a task                                       | Yes           |
| GET       | `/api/project/{projectId}/tasks`                      | Get all tasks for a project                         | Yes           |
| GET       | `/api/projects/{projectId}/tasks/priority/{priority}` | Get tasks by priority (low/high)                    | Yes           |
| GET       | `/api/projects/{projectId}/tasks/status/{status}`     | Get tasks by status (pending/in_progress/completed) | Yes           |

**Create Task Request:**

```json
{
    "title": "Complete API documentation",
    "priority": "high",
    "status": "pending",
    "project_id": 1,
    "due_date": "2024-12-31"
}
```

**Task Priority Values:** `low`, `high`

**Task Status Values:** `pending`, `in_progress`, `completed`

> **Note:** The database migration uses `done` as the status value, but the API accepts `completed`. Ensure consistency when working with the database directly.

### Invitations

| Method | Endpoint                                   | Description             | Auth Required    |
| ------ | ------------------------------------------ | ----------------------- | ---------------- |
| POST   | `/api/invite/{userId}/project/{projectId}` | Send invitation to user | Yes (Owner only) |
| POST   | `/api/invite/{projectId}/accept`           | Accept invitation       | Yes              |

**Accept Invitation:**

```
POST /api/invite/{projectId}/accept
Content-Type: application/json

{
  "token": "invitation-token-from-email"
}
```

### User Info

| Method | Endpoint    | Description                 | Auth Required |
| ------ | ----------- | --------------------------- | ------------- |
| GET    | `/api/user` | Get authenticated user info | Yes           |

## 🔐 Authorization & Permissions

### Project Permissions

-   **Owner**: Full control (view, update, delete)
-   **Admin**: Can create, update, and delete tasks
-   **Member**: Can view tasks (read-only)

### Task Permissions

-   **Project Owner**: Full control over all tasks
-   **Admin Members**: Can create, update, and delete tasks
-   **Regular Members**: Read-only access

## 📊 Database Structure

### Users Table

-   `id`, `name`, `email`, `password`, `email_verified_at`, `remember_token`, `timestamps`

### Projects Table

-   `id`, `name`, `owner_id`, `timestamps`

### Tasks Table

-   `id`, `title`, `due_date`, `priority` (enum: low, high), `status` (enum: pending, in_progress, done), `project_id`, `timestamps`

### Project-User Pivot Table

-   `id`, `user_id`, `project_id`, `token`, `status` (enum: pending, accepted, declined), `role` (enum: member, admin), `timestamps`

## 📧 Email Notifications

The application sends automated emails for:

1. **Welcome Email**: Sent when a user registers
2. **Task Created Email**: Sent when a new task is created
3. **Task Updated Email**: Sent when a task is updated
4. **Invitation Email**: Sent when a user is invited to a project

Emails are queued for better performance. Make sure to run the queue worker:

```bash
php artisan queue:work
```

## 🎯 Usage Examples

### Example: Complete Workflow

1. **Register a user**

    ```bash
    curl -X POST http://localhost:8000/api/auth/register \
      -H "Content-Type: application/json" \
      -d '{
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password123",
        "password_confirmation": "password123"
      }'
    ```

2. **Create a project**

    ```bash
    curl -X POST http://localhost:8000/api/projects \
      -H "Authorization: Bearer YOUR_TOKEN" \
      -H "Content-Type: application/json" \
      -d '{"name": "My Project"}'
    ```

3. **Create a task**

    ```bash
    curl -X POST http://localhost:8000/api/tasks \
      -H "Authorization: Bearer YOUR_TOKEN" \
      -H "Content-Type: application/json" \
      -d '{
        "title": "Complete documentation",
        "priority": "high",
        "status": "pending",
        "project_id": 1,
        "due_date": "2024-12-31"
      }'
    ```

4. **Invite a user to project**
    ```bash
    curl -X POST http://localhost:8000/api/invite/2/project/1 \
      -H "Authorization: Bearer YOUR_TOKEN"
    ```

## 🧪 Testing

Run the test suite:

```bash
composer test
# or
php artisan test
```

## 📁 Project Structure

```
app/
├── Events/              # Event classes (TaskCreatedEvent, TaskUpdatedEvent)
├── Http/
│   ├── Controllers/     # API controllers
│   ├── Requests/        # Form request validation
│   └── Resources/       # API resources
├── Listeners/           # Event listeners for emails
├── Mail/                # Mailable classes
├── Models/              # Eloquent models
└── Policies/            # Authorization policies
database/
├── factories/           # Model factories
├── migrations/          # Database migrations
└── seeders/             # Database seeders
resources/
└── views/
    └── mail/            # Email templates (Blade)
routes/
└── api.php              # API routes
```

## 🔧 Configuration

### Queue Configuration

For email notifications to work properly, configure your queue driver in `.env`:

```
QUEUE_CONNECTION=database
```

Then run migrations to create the jobs table:

```bash
php artisan migrate
```

### Telescope

Laravel Telescope is included for debugging. Access it at `/telescope` (in development mode).

## 📝 Notes

-   All timestamps are in UTC
-   Passwords are hashed using bcrypt
-   API tokens are generated using Laravel Sanctum
-   Email notifications are queued for better performance
-   Task status values: The API accepts `pending`, `in_progress`, `completed`, but the database migration uses `done` instead of `completed`. This inconsistency should be resolved in a future update.

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 👨‍💻 Developer

Mostafa Alaa Mohamed
