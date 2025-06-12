
# Player Mood Board – Laravel Backend

This is the backend API for the Player Mood Board app. It allows players to submit their training mood (😃 😐 😞) and provides endpoints for coaches to view mood summaries and hourly breakdowns.

---

## Tech Stack

- Laravel 11
- PHP 8.2+
- MySQL or PostgreSQL
- RESTful API
- CORS support

---

## Getting Started

### 1. Clone & Install Dependencies

```bash
cd backend
composer install
```


---

### 2. Set Up Environment

Copy the example `.env`:

```bash
cp .env.example .env
```

Update your `.env` with the correct database config:

```env
DB_CONNECTION=mysql         # or pgsql
DB_HOST=127.0.0.1
DB_PORT=3306                # use 5432 for PostgreSQL
DB_DATABASE=player_mood
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

### 3. Run Migrations

```bash
php artisan migrate
```

---

### 4. Serve the API

```bash
php artisan serve
```

API base URL: `http://localhost:8000/api/v1`

---

## API Endpoints

### Submit Mood

**POST** `/api/v1/moods`

```json
{
  "emoji": "happy"
}
```

Returns:

```json
{
  "message": "Mood saved successfully."
}
```

---

### Mood Summary by Date

**GET** `/api/v1/moods?date=2025-06-12`

Returns:

```json
{
  "happy": 4,
  "neutral": 2,
  "sad": 1
}
```

---

### Hourly Mood Breakdown

**GET** `/api/v1/moods/hourly?date=2025-06-12`

Returns:

```json
{
  "data": [
    { "time": "9:00 AM", "happy": 1, "neutral": 0, "sad": 0 },
    { "time": "10:00 AM", "happy": 2, "neutral": 1, "sad": 1 }
  ]
}
```

---

## CORS Setup

Edit `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173'], // React/Vite frontend
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

Then run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

---

## Key Files

* `routes/api.php` — API routes (`/api/v1/...`)
* `app/Http/Controllers/MoodController.php` — Mood logic
* `app/Models/Mood.php` — Eloquent model
* `database/migrations/xxxx_create_moods_table.php` — Table schema

---

## Status

* [X] Mood submission
* [X] Daily mood summary
* [X] Hourly mood breakdown
* [X] CORS ready

---

## License

MIT © 2025
