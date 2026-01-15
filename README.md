# Gestion Étudiants - Laravel Application

Une application de gestion d'étudiants développée avec Laravel, permettant de gérer facilement les inscriptions, les matières et les notes des étudiants via un tableau de bord intuitif et responsive.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

## 📋 Fonctionnalités

### 🖥️ Tableau de Bord
- Vue d'ensemble des statistiques (Total étudiants, notes moyennes, etc.).
- Graphiques de répartition des notes et moyennes par matière.
- Liste des meilleurs étudiants.
- **Entièrement Responsive** : Adapté aux mobiles, tablettes et ordinateurs.

### 🎓 Gestion des Étudiants
- Inscription et gestion des profils étudiants (Nom, Email, Téléphone).
- Recherche rapide.
- Édition et suppression des profils.

### 📚 Gestion des Notes et Matières
- Ajout, modification et suppression des notes.
- Calcul automatique des moyennes.
- Tableaux avec défilement intelligent sur mobile (horizontal et vertical).

## 🚀 Installation et Démarrage

Suivez ces étapes pour lancer le projet en local.

### Prérequis
- [PHP](https://www.php.net/) (v8.1 ou supérieur)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) & NPM
- Base de données (MySQL conseillé)

### 1. Cloner le projet
```bash
git clone https://github.com/votre-repo/gestion-etudiants.git
cd gestion-etudiants
```

### 2. Installer les dépendances
```bash
# Dépendances PHP
composer install

# Dépendances JavaScript/CSS
npm install
```

### 3. Configuration de l'environnement
Copiez le fichier d'exemple `.env` et configurez votre base de données :
```bash
cp .env.example .env
php artisan key:generate
```
Puis ouvrez le fichier `.env` et modifiez les lignes suivantes selon votre configuration MySQL :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_student
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Base de données
Créez la base de données et lancez les migrations :
```bash
php artisan migrate
```
*(Optionnel) Pour avoir des données de test :*
```bash
php artisan db:seed
```

### 5. Lancer l'application
Vous aurez besoin de deux terminaux pour lancer l'application en mode développement.

**Terminal 1 (Serveur Laravel) :**
```bash
php artisan serve
```

**Terminal 2 (Compilation Assets Vite) :**
```bash
npm run dev
```

L'application sera accessible à l'adresse : [http://127.0.0.1:8000](http://127.0.0.1:8000)

## 📱 Responsivité
L'interface a été optimisée pour tous les types d'écrans :
- **Navigation** : Barre latérale rétractable sur mobile.
- **Tableaux** : Défilement horizontal et vertical automatique sur les petits écrans pour une lisibilité maximale.
- **Formulaires** : Mise en page adaptative.

## 📄 Licence
Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).
