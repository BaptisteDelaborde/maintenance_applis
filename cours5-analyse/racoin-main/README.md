## 2) Prise en main & démarrage (local)

## Prérequis

- Docker
- Docker Compose

## Fichiers utiles

- `docker-compose.yml` : services applicatifs
- `docker/php/Dockerfile` : image PHP
- `config/config.ini` : configuration de connexion BDD
  - Exemple de fichier `config/config.ini` :
    - PHP_PORT=8080
    - DB_PORT=3306
    - DB_HOST=db
    - DB_DATABASE=racoin
    - DB_USERNAME=root
    - DB_PASSWORD=rootpassword

- `sql/create_schema.sql` et `sql/import_data.sql` : structure + données

## Démarrage rapide

Depuis le dossier `racoin-main` :

```bash
composer install --no-security-blocking
docker-compose up -d
