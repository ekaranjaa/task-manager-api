# Task Manager 📋

Using Laravel and VueJs design and implement an appointment module that does the following:

- Employee can set their availability e.g available on weekdays 8:00 AM to 5:00 PM weekend half day.
- Assign an employee a task when they are available.
- employee can login and see the tasks assigned.

## Build Setup ⚙️

```bash
# Install dependencies
composer install

# Copy .env.example and fill in your configuration
cp .env.example .env

# Generate key
php artisan key:generate
```

## Setting up database 💾

After configuring your `.env` variables, run the migrations and seed the database.

```
php artisan migrate --seed
```

An admin user has been created for you:

> Email: admin@ex.com
> Password: password

## Serving application 🔗

Create a virtual host with the domain `api.taskmanager.test`
If serving via artisan `php artisan serve` then make sure the [frontend app](https://github.com/ekaranjaa/task-manager) axios configuration points to the this api host.

For detailed explanation on how things work, check out [Larave docs](https://laravel.com).

Enjoy 🌟

<p align="center">Made with ❤️ in 🇰🇪</p>
