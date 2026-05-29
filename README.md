# 🌲 QR Game

A mobile-first multiplayer QR code scavenger hunt built with:
**Laravel 13 · Filament 3 · Livewire 3 · Alpine.js · Tailwind CSS v4 · Laravel Reverb**

---

## Setup

### 1. Scaffold the project structure

The project uses a one-shot PHP setup script to create directories and all app files.
Run it once from the project root:

```bash
php create_dirs.php
```

Or double-click `run_script.bat` on Windows.

### 2. Install dependencies (if not already done)

```bash
composer install
npm install
```

### 3. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database credentials.

### 4. Run migrations

```bash
php artisan migrate
```

### 5. Create your first admin account

```bash
php artisan make:filament-user
```

### 6. Start the development server

```bash
# Option A — all-in-one (server + queue + logs + Vite)
composer run dev

# Option B — manual
php artisan serve
npm run dev
```

### 7. Start the WebSocket server (when you need realtime features)

```bash
php artisan reverb:start
```

---

## URLs

| URL | Description |
|-----|-------------|
| `/` | Player join page |
| `/scoreboard` | Public live scoreboard |
| `/play` | Player dashboard (requires group session) |
| `/scan/{token}` | QR encounter page |
| `/admin` | Filament admin panel |
