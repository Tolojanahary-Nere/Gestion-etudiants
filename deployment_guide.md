# Déploiement et Intégration Portfolio

## 1. Déploiement du Projet Laravel

Puisque le code est déjà sur GitHub (`git@github.com:Tolojanahary-Nere/Gestion-etudiants.git`), vous avez plusieurs options pour mettre l'application en ligne :

### Option A : Hébergement Facile (Railway / Render)
C'est souvent la méthode la plus simple pour les portfolios.
1.  Créez un compte sur [Railway.app](https://railway.app/) ou [Render.com](https://render.com/).
2.  Connectez votre compte GitHub.
3.  Sélectionnez le dépôt `Gestion-etudiants`.
4.  Railway/Render détectera automatiquement Laravel.
5.  **Variables d'environnement** : Ajoutez les clés de votre fichier `.env` (`APP_KEY`, `DB_CONNECTION`, etc.). Pour la base de données, Railway fournit un service MySQL/PostgreSQL facile à lier.

### Option B : Lien GitHub (Code Source uniquement)
Si vous ne souhaitez pas payer ou gérer un serveur, vous pouvez simplement présenter le code source. C'est très courant pour les projets de portfolio.

---

## 2. Intégration dans "Nere_Portfolio"

Puisque je n'ai pas accès direct au dossier `Nere_Portfolio`, voici les étapes pour l'ajouter manuellement.

### Étape 1 : Capture d'écran
Prenez une capture d'écran de votre Tableau de Bord (Dashboard) pour l'utiliser comme image de couverture. Sauvegardez-la dans le dossier images de votre portfolio (ex: `public/images/projects/gestion-student.png`).

### Étape 2 : Mise à jour du fichier de données
Trouvez votre fichier `src/data/translation.json` (ou équivalent) dans votre portfolio et ajoutez cette entrée dans la section `projects` :

```json
{
  "id": "gestion-students",
  "title": "Gestion Étudiants",
  "description": {
    "fr": "Application de gestion scolaire complète avec tableau de bord analytique. Permet la gestion des étudiants, matières et notes avec calcul automatique des moyennes et statistiques graphiques.",
    "en": "Comprehensive school management application with analytics dashboard. Features student, subject, and grade management with automatic average calculation and graphical statistics."
  },
  "technologies": ["Laravel 10", "Bootstrap 5", "Chart.js", "MySQL", "SASS"],
  "githubLink": "https://github.com/Tolojanahary-Nere/Gestion-etudiants",
  "liveLink": "", 
  "image": "/images/projects/gestion-student.png",
  "featured": true
}
```
*(Adaptez les clés `fr/en` ou le format selon la structure exacte de votre fichier JSON)*.
