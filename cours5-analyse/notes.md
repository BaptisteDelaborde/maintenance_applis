# Etapes à réaliser

## 1. Analyse théorique (30min)
### Sans lancer le projet, essayez de répondre aux questions suivantes, et notez vos réponses dans le fichier notes.md :

### Trouver le ou les langages utilisé
Les langages utilisé sont : 
- **PHP** : langage principal du backend
- **JavaScript** : interactions frontend (DOM manipulation, etc.)
- **CSS/SCSS** : stylisation des pages
- **SQL** : base de données
- **YAML/JSON** : fichiers de configuration (docker-compose.yml, composer.json)

### Trouver le ou les framework principaux utilisé
Les framework utilisé sont :
- **Slim 2** : micro-framework PHP pour le routage et les requêtes HTTP
- **Twig 1.0** : moteur de templates PHP
- **Illuminate Database 4.2.9** : couche ORM/Query Builder (Laravel Eloquent)

### Trouvez le but général de l'application
L'application Racoin est une **plateforme de petites annonces** (site de ventes/achats d'occasion). Elle permet aux utilisateurs (annonceurs) de :
- Publier des annonces avec photos
- Consulter les annonces par catégories et départements
- Rechercher des articles
- Gérer leurs profils d'annonceurs

### Faire une première estimation de ce qu'il faudrait pour faire démarrer l'application en l'état
Pour faire démarrer l'application, il faudrait :
1. **Composer install** pour les dépendances
2. **Docker compose** pour la base de données et le serveur web 
3. Configurer la connexion BD dans `config/config.ini`
4. Importer le schéma SQL et les données de test
5. Compiler le scss

## 2. Prise en main & démarrage (30min)

### Faire marcher l'application en local

**Étapes réalisées:**

1. Créé le fichier `config/config.ini` avec les paramètres de connexion à MySQL
2. Amélioré le `docker-compose.yml` pour ajouter un service MySQL 8.0
3. Configuré les volumes pour que le schéma SQL s'initialise automatiquement
4. Ajouté un health check pour MySQL

**Pour démarrer l'application :**
```bash
docker-compose up -d
docker-compose exec php composer install
# Ensuite accédez à http://localhost:8080
```

### Créer un process et un mode d'emploi pour faire marcher l'application

**Fichiers créés/modifiés:**

1. **README.md** - Documentation complète
2. **docker-compose.yml** - Configuration Docker améliorée:
   - Service PHP 7.4 avec accès au code local
   - Service MySQL 8.0 avec initialisation automatique
   - Configuration de la base de données (racoin/rootpassword)
   - Health checks pour MySQL
3. **config/config.ini** - Fichier de configuration:
   - Paramètres de connexion à la base de données MySQL
   - Configuration pour Illuminate Database
4. **.env** - Fichier d'exemple pour variables d'environnement

## 3. Préparer la maintenance (30min)

### Lister les langages et frameworks dont la version est obsolète

### Lister les dépendances non maintenues / obsolètes

### Notez dans une section "Todo list" d'autres améliorations que vous avez en tête pour la maintenance et l'évolution de l'application. Gardez en tête le préambule ci dessus.

### Pour chaque idée, essayer de noter sur 10 le temps de la modification, et l'impact de la modification (2 notes donc) afin de prioriser les évolutions futures.

## 4. Réaliser la maintenance (1h30)
### Mettre à jour les versions de langages et de framework
### Mettre à jour les dépendances obsolètes

## 5. Étape (bonus) - effectuer de l'amélioration continue

### Appliquer certaines des améliorations que vous aviez envisagées en étape 3

### Faire une liste des améliorations que vous avez faites, avec une explication rapide de pourquoi vous avez séléctionné celle(s)-ci parmi vos idées initiales._
