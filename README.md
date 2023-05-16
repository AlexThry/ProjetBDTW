# Projet BDD

## TodoList

Des trucs à faire :
- Dans account.php, voir toutes **nos** questions
- Dans index.php, voir toutes les questions (avec pagination)
- Réutiliser la recherche du projet précédent pour trouver des questions (page search-results.php, méthode Database::search_books et Database::get_sorted_books)
    - Recherche par texte
    - Recherche par catégorie
    - Tri par nombre de likes
    - Tri par date de création
- Dans admin-dashboard.php, faire le form pour ajouter une catégorie
- Dans admin-dashboard.php, faire le form pour supprimer une catégorie
- Dans admin-dashboard.php, voir les questions non validés
- Dans admin-dashboard.php, validé une question
- Dans admin-dashboard.php, voir les questions non répondues
- Dans admin-dashboard.php, répondre à une question de manière courte (sans html)

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
