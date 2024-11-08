# Come far partire il progetto

## Come far partire il progetto in locale

### Requisiti di sistema

- **PHP 8.2 o superiore**
- **Composer 2.5 o superiore**
- **Node js e npm**

### Installazione delle dipendenze

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Dopo copiato il file `.env` e generato la chiave di sicurezza copiare le impostazioni del database nel file `.env`.
Se si vuole utilizzare un database locale decommentare le righe commentate con `#` e inserire le impostazioni del database (io ho utilizzato supabase un db postgres online per il quale serve solo configurare il DATABASE_URL)

```env
DB_CONNECTION=pgsql
DATABASE_URL=postgres://postgres.xxxx:password@xxxx.pooler.supabase.com:5432/postgres
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

### Popolamento del database

```bash
php artisan migrate
php artisan db:seed --class=TestSeeder
```

