# 🌲 QRGame — Dark Magical Forest QR Hunt

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

---

## App Structure

```
app/
├── Actions/
│   └── Game/           ← thin single-responsibility action classes
│       ├── JoinGame.php
│       ├── ProcessScan.php
│       └── SubmitChallenge.php
├── Events/             ← broadcastable events
│   ├── PlayerJoined.php
│   └── ScoreUpdated.php
├── Filament/
│   └── Resources/      ← Filament admin resources
│       └── UserResource/
├── Http/
│   ├── Controllers/    ← thin controllers, delegate to Actions/Services
│   └── Middleware/
│       └── RequireGroupSession.php
├── Models/             ← Eloquent models
├── Providers/
│   └── Filament/
│       └── AdminPanelProvider.php
└── Services/
    ├── ScoreboardService.php
    └── SessionService.php   ← anonymous player session management

resources/
├── css/
│   ├── app.css              ← Tailwind v4 + dark forest theme
│   └── filament/admin/      ← Filament custom theme
├── js/
│   └── app.js               ← Alpine.js game components + Laravel Echo
└── views/
    ├── layouts/
    │   ├── app.blade.php    ← public layout
    │   └── game.blade.php   ← in-game layout
    └── game/                ← all game views
```

---

## Broadcasting / Realtime

Realtime support is wired but not yet active. The stack is ready:

- **Laravel Reverb** — WebSocket server (`php artisan reverb:start`)
- **Laravel Echo + Pusher-JS** — client-side listener (configured in `resources/js/app.js`)
- **Broadcasting channels** — defined in `routes/channels.php`
- **Events** — `ScoreUpdated` and `PlayerJoined` implement `ShouldBroadcast`

To go live: set `BROADCAST_CONNECTION=reverb` in `.env` (the setup script does this automatically)
and start Reverb alongside your queue worker.

---

## Theme

The dark magical forest theme is defined in `resources/css/app.css` via Tailwind v4's `@theme` block:

- Background palette: `forest-deep`, `forest-dark`, `forest-card`
- Accent: `forest-green` (#22c55e) / `forest-glow` (#00ff9d)
- Rarity colours: `common`, `rare`, `epic`, `cursed`, `legendary`
- CSS utility classes: `.game-card`, `.btn-primary`, `.rarity-badge`, `.scan-pulse`, etc.
- Animations: encounter reveals, score pop, rank transitions, confetti, bomb shake

