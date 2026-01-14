# Guide de Déploiement sur Render

Votre projet est prêt àêtre déployé. Suivez ces étapes sur le site de Render :

## 1. Création du Service Web
1.  Connectez-vous sur [dashboard.render.com](https://dashboard.render.com/).
2.  Cliquez sur **New +** et sélectionnez **Web Service**.
3.  Connectez votre compte GitHub et choisissez le dépôt `Gestion-etudiants`.

## 2. Configuration
Remplissez le formulaire avec ces valeurs exactes :

*   **Name**: `gestion-etudiants` (ou ce que vous voulez)
*   **Region**: Frankfurt (ou le plus proche)
*   **Branch**: `main`
*   **Runtime**: **PHP**
*   **Build Command**: `./bin/render-build.sh`
*   **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`
    *   *Note : Pour une production optimale, on utiliserait Nginx, mais `artisan serve` fonctionne bien pour un projet de portfolio.*

## 3. Variables d'Environnement
Dans la section "Environment Variables", ajoutez :

| Key | Value |
| :--- | :--- |
| `APP_Key` | (Copiez celle de votre `.env` local ou générez-en une) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `true` (utile pour débugger au début, mettez `false` après) |
| `APP_URL` | (Laissez vide pour l'instant, Render la fournira) |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | (Voir étape 4 ci-dessous) |
| `DB_PORT` | `5432` |
| `DB_DATABASE` | (Voir étape 4) |
| `DB_USERNAME` | (Voir étape 4) |
| `DB_PASSWORD` | (Voir étape 4) |

## 4. Base de Données (PostgreSQL)
1.  Ouvrez un nouvel onglet Render.
2.  Cliquez sur **New +** -> **PostgreSQL**.
3.  Nommez-la `gestion-db`.
4.  Une fois créée, copiez les "Internal Connection Details" (Hostname, Database, Username, Password) et mettez-les dans les variables d'environnement de votre Web Service (étape 3).

## 5. Déployer
Cliquez sur **Create Web Service**. Render va télécharger le code, lancer le script de build, et démarrer le serveur.
