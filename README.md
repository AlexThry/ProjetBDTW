# Projet BDD

## TodoList

- **CHANGER BD pour distinguer questions validés / invalidés**
- Dans l'espace compte | **`Carlyne Lois`**
    - Changer ses identifiants
    - Voir toutes **nos** questions
    - Voir la réponse ou le message "Pas de réponse, patientez svp"
    - Voir le contenu additionnel de la réponse

- Dans la page d'accueil | **`Ronan`**
    - Voir toutes les questions (avec pagination)
    - Recherche par texte (seulement le texte de la quesiton)
    - (Recherche par texte (avec le texte des réponses))
    - Recherche par catégorie
    - Tri par nombre de likes
    - Tri par date de création
    - Tri répondu / pas répondu
    - (Tri validés et invalidés (seulement pour l'admin))
    - Dans la top bar, affiché un bouton "Poser une question"

- Dans l'espace admin | **`Hugo Ugo`**
    - [FIX] Responsive design dans l'onglet interface admin'
    - ✔️ Faire le form pour ajouter une catégorie
    - ✔️ Faire le form pour supprimer une catégorie
    - Voir les questions non validés
    - Validé une question
    - Voir les questions non répondues
    - (Tri questions validés et invalidés)
    - (Dans un onglet paramètre, afficher l'option "Afficher le bouton ajouter une question dans la topbar") (voir Arnaud si tu comprends pas)

- Dans la page d'une question | **`Arnaud Alexis`**
    - Voir l'intitulé, la date, etc
    - Voir le nombre de likes
    - Voir la réponse ou un message "Pas répondu, patientez plz"
    - Voir qui a répondu (nom, image de profil, date de la réponse)
    - (Voir si la question à été édité par l'admin)
    - Répondre à une question de manière courte
    - Répondre à une question de manière longue (markdown)


## Architecture

 - `.` la racine contient les pages html, les fichiers de configuration et un exemple de contenu de la base de donnée (`proj631.md`).
 - `includes` contient des bouts de code html réutilisable.
 - `core` contient des fonctions et scripts s'occupant de la logique du site (soumission de formulaire, redirection, rooting, ...)

## Normalisation

 - Si vous écrivez du JavaScript déclencher le script comme ceci
````js
document.addEventListener('DOMContentLoaded', function() {
    // your code here...
});
````
 - Veillez à écrire votre code en anglais.
 - Mettez une majuscule à vos noms de classe php.
 - Ne fermez pas php à la fin d'un fichier si il est ouvert.
 - 99.99% du temps, une méthode ou fonction doit commencer par un verbe.
 - en `php` écrire en snake_case.
 - Quand vous déclarez une classe en PHP, vérifiez si elle n'a pas déjà été déclarée.

## Sécurité

Veillez à échapper les entrées et sorties avec la function `htmlentities`.
Les mots de passe sont hashés avec la fonction `md5`.
Veillez à prendre la dernière version de la base de donnée (les mots de passes natifs sont 'root').

## Pour contribuer

Ajouter `feature:`, `fix:` ou `clean:` au début de vos messages de commit.
