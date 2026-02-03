# Begraafplaats-beheer

This project is a **Laravel + Svelte** application for managing cemetery administration. This README explains how to run the project **locally** for development.

## Requirements

Make sure you have the following installed on your system:

* **PHP** >= 8.1
* **Composer**
* **Node.js** >= 18
* **npm** or **pnpm**
* **MySQL**
* **Git**
* A local database tool

## Project Setup

### Clone the repository

```bash
git clone https://github.com/JesperD17/Begraafplaats-beheer.git
cd Begraafplaats-beheer
```

### Install backend dependencies (Laravel)

```bash
composer install
```

### Install frontend dependencies (Svelte)

```bash
npm install
# or
pnpm install
```

## Environment Configuration

### Create environment file

```bash
cp .env.example .env
```

Edit `.env` and configure at least:

```env
APP_NAME=BegraafplaatsBeheer
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=begraafplaats
DB_USERNAME=root
DB_PASSWORD=
```

---

### Generate application key

```bash
php artisan key:generate
```

## Database Setup

### Run migrations (and seeders if available)

```bash
php artisan migrate
# optional
php artisan db:seed
```

If you want a fresh database:

```bash
php artisan migrate:fresh --seed
```

## Running the Project

### Start the Laravel backend

```bash
php artisan serve
```

The backend will be available at:

```
http://127.0.0.1:8000
```

---

### Start the frontend (Vite / Svelte)

In a **separate terminal**:

```bash
npm run dev
# or
pnpm dev
```

This starts Vite for hot‑reloading frontend assets.

## Notes

* This project uses **Laravel + Vite + Svelte**
* Backend logic lives in `app/`
* Frontend components live in `resources/`
* Routes are defined in `routes/`

## Contributors

This project was originally developed by the following team. As the project will be taken over by new developers, this section serves as credit for the initial development and as a point of reference.

Original Development Team

- Jesper Drent (@JesperD17) – Project lead / Full‑stack development
- Colin Fransman (@ColinFransman) – Backend development
- Manon Zaagman (@idontknow83) – Frontend development
