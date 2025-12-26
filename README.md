# Plateforme de gestion de réservation sportif CoachConnect

## Description
une plateforme web dédiée à la mise en relation entre sportifs et coachs professionnels.
Le projet est développé en **PHP orienté objet**, avec une base de données **MySQL** et l’accès aux données via **PDO**.


## Acteurs
- **Coach**
  - S’inscrire et se connecter
  - Créer et supprimer ses séances
  - Voir les séances réservées par les sportifs

- **Sportif**
  - S’inscrire et se connecter
  - Consulter les séances disponibles
  - Réserver une séance
  - Voir ses propres réservations


## Technologies utilisées
- PHP (Programmation Orientée Objet)
- MySQL
- PDO
- HTML5
- CSS natif


## Base de données
Nom de la base : **coachconnect**

### Tables principales :
- `users`
- `coaches`
- `sportifs`
- `seances`
- `reservations`

Les relations sont gérées avec des clés étrangères :
- Un **coach** possède plusieurs séances
- Un **sportif** peut réserver une seule fois une séance
- Une séance réservée devient indisponible


## Concepts POO appliqués
- Encapsulation
- Constructeurs
- Getters et setters
- Héritage :
  - `Utilisateur` → `Coach` / `Sportif`
- Séparation des responsabilités :
  - `Seance` : gestion des séances
  - `Reservation` : gestion des réservations


## Sécurité
- Accès aux pages protégé par les sessions
- Vérification des rôles (coach / sportif)
- Utilisation de requêtes préparées avec PDO

