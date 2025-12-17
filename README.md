# Fuvarozó Rendszer - Laravel

```bash
# 1. Repository klónozása
git clone <repository-link>
cd fuvar-rendszer

# 2. Függőségek
composer install
npm install

# 3. Környezet
cp .env.example .env
php artisan key:generate

# 4. SQLite adatbázis (egyszerű)
touch database/database.sqlite

# 5. Adatbázis és teszt adatok
php artisan migrate --seed

# 6. Indítás
php artisan serve
Nyisd meg: http://localhost:8000

Bejelentkezés
Admin:

Email: admin@fuvar.test

Jelszó: admin123

Fuvarozó (5 db):

Email: fuvarozo1@example.com ... fuvarozo5@example.com

Jelszó: password

Főbb oldalak
Admin
Dashboard: /admin/dashboard

Munkák: /admin/munkak

Új munka: /admin/munkak/create

Fuvarozó
Dashboard: /fuvarozo/dashboard

Saját munkák: /fuvarozo/munkak

Ha nem működik
"Target class does not exist"

bash
composer dump-autoload
php artisan config:clear
Adatbázis hiba

bash
php artisan migrate:fresh --seed
Nincs kulcs

bash
php artisan key:generate
Feladat ellenőrzés
Kötelező (mind kész):

Laravel 10

Admin + Fuvarozó szerepkörök

Fuvarozó, Jármű, Munka modellek

CRUD műveletek

Munka hozzárendelés

Státusz módosítás (4 állapot)

Authentication

GitHub repository

Bónusz (mind kész):

Státusz szűrés

API végpontok

PHPUnit tesztek
