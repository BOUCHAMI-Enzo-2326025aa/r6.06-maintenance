# 🏆 Système de Gestion de Championnats Sportifs

Application web pour créer et gérer des championnats sportifs avec compétitions et épreuves.

## 🎯 Vue d'ensemble

Ce projet permet aux administrateurs de :
- **Gérer les sports** : Créer des sports avec différents types (individuel, équipe, relais, individuel/équipe)
- **Créer des championnats** : Configurer des championnats avec plusieurs compétitions
- **Organiser les compétitions** : Ajouter des épreuves aux compétitions avec leurs modes d'inscription
- **Consulter les détails** : Visualiser complètement la structure d'un championnat

## 🏗️ Architecture

### Stack Technique
- **Frontend** : Vue 3 + Vite + Tailwind CSS
- **Backend** : Laravel 11 (API REST)
- **Tests** : Behat + Playwright (E2E)
- **Base de données** : MySQL/PostgreSQL

### Structure du Projet

```
project/
├── frontend/
│   ├── src/
│   │   ├── pages/
│   │   │   ├── Sports.vue           # Catalogue des sports
│   │   │   ├── Championnats.vue     # Liste des championnats
│   │   │   └── ChampionnatDetails.vue # Détails d'un championnat
│   │   ├── services/
│   │   │   ├── sportsApi.js
│   │   │   ├── championnatsApi.js
│   │   │   └── apiClient.js
│   │   ├── components/
│   │   │   └── ui/
│   │   │       ├── BaseTable.vue
│   │   │       └── BaseModal.vue
│   │   └── App.vue
│   ├── vite.config.js
│   └── package.json
│
├── backend/
│   ├── app/
│   │   ├── Models/
│   │   │   ├── Sport.php
│   │   │   ├── Championnat.php
│   │   │   ├── Competition.php
│   │   │   └── Epreuve.php
│   │   ├── Http/
│   │   │   ├── Controllers/Api/SportController.php
│   │   │   └── Requests/
│   │   │       ├── StoreSportRequest.php
│   │   │       └── UpdateSportRequest.php
│   │   └── Http/Controllers/Api/ChampionnatController.php
│   ├── routes/
│   │   └── api.php
│   ├── database/
│   │   └── migrations/
│   └── .env.example
│
└── tests/
    ├── features/
    │   ├── sports.feature
    │   ├── championnats.feature
    │   └── championnat-details.feature
    └── bootstrap/
        └── FeatureContext.php
```

## 🚀 Installation

### Prérequis
- PHP >= 8.0
- Node.js >= 16
- Composer
- MySQL/PostgreSQL

### Backend (Laravel)

```bash
# Cloner et installer
cd backend
composer install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed  # Optional

# Démarrer le serveur
php artisan serve  # http://127.0.0.1:8000
```

### Frontend (Vue 3 + Vite)

```bash
# Installer les dépendances
cd frontend
npm install

# Démarrer le serveur de développement
npm run dev  # http://localhost:5173
```

### Scénarios couverts

**Sports** (3 scénarios)
- ✅ Créer un sport individuel
- ✅ Créer un sport d'équipe
- ✅ Validation des champs obligatoires

**Championnats** (3 scénarios)
- ✅ Créer un championnat avec compétition
- ✅ Ajouter plusieurs compétitions
- ✅ Validations (sport obligatoire)

**Détails** (3 scénarios)
- ✅ Afficher les détails d'un championnat
- ✅ Lister les compétitions et épreuves
- ✅ Navigation (retour à la liste)

## 🔄 Flux utilisateur

### 1️⃣ Créer des Sports
```
Page Sports
  → Cliquer "+ Nouveau Sport"
  → Remplir : Nom + Type
  → Confirmer
  → Sport ajouté au catalogue
```

### 2️⃣ Créer un Championnat
```
Page Championnats
  → Cliquer "+ Créer un Championnat"
  → Sélectionner un Sport
  → Remplir : Nom + Lieu
  → Ajouter Compétition(s)
    → Ajouter Épreuve(s)
      → Ajouter Sport(s) à l'épreuve
  → Enregistrer
  → Championnat créé
```

### 3️⃣ Consulter les Détails
```
Page Championnats
  → Cliquer "Voir plus" sur un championnat
  → Affichage : Infos + Compétitions + Épreuves
  → Cliquer "← Retour" pour revenir
```