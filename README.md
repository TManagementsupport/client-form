# Client Form

Formulaire PHP pour recevoir le nom complet et l'âge des clients.

## Installation locale XAMPP

1. Copier le dossier dans `C:\xampp\htdocs\client-form`.
2. Dans le dossier du projet, lancer :
   ```bash
   composer install
   ```
3. Copier `.env.example` en `.env`.
4. Créer la base MySQL `client_form_db` dans phpMyAdmin.
5. Ouvrir : `http://localhost/client-form/`

## Admin

Page : `http://localhost/client-form/login.php`

Modifier `ADMIN_USER` et `ADMIN_PASS` dans `.env`.

## Email

Pour Gmail, utiliser un mot de passe d'application dans `SMTP_PASS`.
