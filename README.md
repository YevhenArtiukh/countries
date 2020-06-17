## Instalacja

Korzystając z pakiet managera Composer, instalujemy wszystkie biblioteki.
 
```bash
composer install
```

## Baza danych

Do pliku .env wpisujemy dane połączenia do DB. Od razu można wpisać dane do maila. Po tym wykonujemy następujące komendy.
```bash
php bin/console doctrine:database:create
php bin/console doctrine:schema:update -f
php bin/console doctrine:fixtures:load
```

## Korzystanie

Po wykonaniu ostatniej komendy, mamy 2 konta:
 - login: user, password: user
 - login: admin, password: admin