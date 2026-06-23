Développer une application web de gestion commerciale permettant de gérer les produits, ventes, achats et la génération de factures imprimables.
La méthodologie utilisée est une approche incrémentale. Le projet a été développé module par module : gestion des produits, ventes, achats, puis facturation et authentification.
- PHP (Back-end)
- MySQL / MariaDB (Base de données)
- PDO (connexion sécurisée à la base de données)
- HTML5
- Bootstrap 5 (interface utilisateur)
- JavaScript (impression et interactions simples)
- XAMPP (environnement local de développement)
L'application est structurée en plusieurs modules :
- products/
- sales/
- purchases/
- config/
- layout/
Chaque module gère une fonctionnalité spécifique.
- Gestion des produits (ajout, liste)
- Gestion des ventes avec facturation
- Gestion des achats avec mise à jour du stock
- Authentification utilisateur (login/register)
- Génération automatique de numéros de factures
- Impression des factures
