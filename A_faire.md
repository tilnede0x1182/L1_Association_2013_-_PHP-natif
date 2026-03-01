# À faire

## 1. Compréhension rapide
- Le site fournit inscription/connexion (`PageConnection.php`, `Connection1.php`, `VerifieConnection.php`), avec stockage dans MySQL (`asso`, `posts`, `projets`, etc.).
- Les membres peuvent créer/modifier des articles (`EcritureNouveauPost.php`, `ModifierArticle.php`), des projets (`NouveauProjet.php`) et gérer leurs informations (`ModifierInformationMembre.php`).
- Les pages listent les membres (`ListeDesMembres.php`), articles (`ListeDesPosts.php`, `ListeCompletePosts.php`) et projets (`ListedesProjet.php`) avec différentes vues et filtres.
- Deux thèmes CSS (dossier `Styles`) et une inclusion conditionnelle (`Fonctions/includeStylesheet.php`) personnalisent l’affichage.
- `Fonctions/ConnectionBaseDonnees.php` centralise les identifiants de base, tandis que `Fonctions/AdresseServeur.php` définit l’URL racine pour construire les liens.
- Les scripts `MenuAccueil.php`, `Header`/`Footer` partagent la navigation et les éléments graphiques.

## 2. Bugs à corriger
- `EcritureNouveauPost.php` initialise `$_SESSION['id']` et `$_SESSION['motdepasse']` à `80` lorsqu’ils sont vides. Un visiteur non authentifié peut donc publier des articles sous l’ID 80. Il faut bloquer l’accès si la session n’est pas renseignée, pas injecter un ID par défaut.
- `Connection1.php` construit la requête `UPDATE asso ... WHERE id="$_SESSION['id']"` en injectant directement les valeurs de session. Si un attaquant parvient à stocker des guillemets dans `$_SESSION` (ex. via poisonning), la requête se brise ; mieux vaut utiliser des requêtes préparées.
- Plusieurs formulaires testent les regex mais n’empêchent pas l’injection HTML côté base (ex. `EcritureNouveauPost.php` nettoie au `htmlspecialchars` mais ne vérifie pas la longueur). Limiter à 65k caractères et rejeter les tags limitera les erreurs lors de l’affichage.

## 3. DRY en priorité
- Chaque page PHP inclut manuellement `Fonctions/ConnectionBaseDonnees.php`, se connecte via `mysql_pconnect` et répète les mêmes `if (!$connexion) { ... }`. Centraliser ces vérifications dans un helper (ou passer à PDO) économiserait des dizaines de lignes.
- Les formulaires `Connection1.php`, `PageConnection.php`, `EcritureNouveauPost.php`, etc. dupliquent les messages d’erreur HTML. Utiliser un composant de template (ou au moins une fonction `render_form($errors, $fields)`) clarifierait le flux.

## 4. Sécurité
- Toute la couche SQL repose sur l’extension obsolète `mysql_*` et concatène les valeurs d’entrée directement dans les requêtes. Il faut migrer vers PDO/MySQLi avec requêtes préparées pour éliminer les injections SQL.
- Les mots de passe sont hachés en MD5 sans sel (`$_SESSION['motdepasse']=md5($_POST['motdepasse']);`). Les stocker avec `password_hash()`/`password_verify()` (bcrypt) est indispensable en 2025.
- Aucune protection CSRF n’entoure les formulaires critiques (suppression de membre/projet). Ajouter des tokens anti-CSRF par session évitera des suppressions involontaires.
