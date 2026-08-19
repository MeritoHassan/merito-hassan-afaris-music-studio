# Specifications fonctionnelles

## 1. Presentation du projet

**Nom du projet :** Afaris Music Studio  
**Technologie :** Symfony 7, Twig, Doctrine ORM, Security Bundle, Mailer  
**Type de projet :** site web dynamique sans CMS  
**Client fictif :** un studio creatif qui publie des actualites, presente ses activites et echange avec sa communaute.

L'application a pour objectif de fournir un site vitrine et editorial pour Afaris Music Studio. Le visiteur peut consulter les actualites, lire le detail d'une publication, s'inscrire, se connecter et contacter le studio. Un backoffice permet a un administrateur de gerer les contenus et les utilisateurs.

## 2. Objectifs fonctionnels

Le site doit permettre :

- de valoriser graphiquement les trois dernieres actualites sur la page d'accueil
- de consulter l'ensemble des actualites avec pagination
- de lire une actualite complete
- de publier un commentaire sur une actualite en etant connecte
- de signaler un commentaire inapproprie
- de presenter l'activite du studio
- d'envoyer un message via un formulaire de contact
- de creer un compte utilisateur
- de se connecter et se deconnecter
- d'administrer les posts, les commentaires, les utilisateurs et les images depuis un backoffice securise

## 3. Utilisateurs

### 3.1 Visiteur

Le visiteur non connecte peut :

- consulter la page d'accueil
- consulter la liste des actualites
- consulter le detail d'une actualite
- acceder a la page de presentation
- utiliser le formulaire de contact
- acceder a l'inscription et a la connexion

### 3.2 Utilisateur inscrit

L'utilisateur connecte peut :

- effectuer toutes les actions du visiteur
- publier un commentaire sur une actualite
- signaler un commentaire

### 3.3 Administrateur

L'administrateur peut :

- acceder au backoffice
- creer, modifier, afficher et supprimer des posts
- gerer les commentaires signales ou non
- creer, modifier et supprimer des utilisateurs
- ajouter, modifier et supprimer des images liees aux posts

## 4. Fonctionnalites du front office

### 4.1 Page d'accueil

La page d'accueil met en avant les trois dernieres actualites. Elle doit etre essentiellement graphique et permettre d'acceder rapidement :

- au detail d'une actualite
- a la liste complete des actualites
- a la page de presentation du studio

### 4.2 Page d'actualites

La page d'actualites affiche tous les posts publies avec un systeme de pagination. Les actualites sont triees par date de creation decroissante.

### 4.3 Detail d'une actualite

Chaque actualite dispose d'une page detaillee affichant :

- le titre
- le contenu
- les images associees
- la date de publication
- l'auteur
- les commentaires associes

Un utilisateur connecte peut ajouter un commentaire. Chaque commentaire peut etre signale via un bouton dedie.

### 4.4 Page de presentation

La page de presentation expose le positionnement du studio, son activite et quelques chiffres clefs.

### 4.5 Page de contact

La page de contact contient un formulaire avec validation. Lors de la soumission, un email est envoye a l'adresse de contact configuree dans l'application.

### 4.6 Inscription

L'inscription permet de creer un compte avec :

- nom d'utilisateur unique
- email unique
- mot de passe

Un email de verification est envoye apres la creation du compte.

### 4.7 Connexion

La connexion se fait par formulaire Symfony Security. Un mecanisme "remember me" permet de maintenir la session.

## 5. Fonctionnalites du backoffice

### 5.1 Gestion des posts

Le backoffice permet :

- la creation d'un post
- la modification d'un post
- la suppression d'un post
- l'affichage detaille d'un post

### 5.2 Gestion des commentaires

Le backoffice permet :

- la consultation de tous les commentaires
- la priorisation visuelle des commentaires signales
- la modification d'un commentaire
- la suppression d'un commentaire
- l'activation ou la desactivation de l'etat "signale"

### 5.3 Gestion des utilisateurs

Le backoffice permet :

- la creation d'un utilisateur
- la modification d'un utilisateur
- la suppression d'un utilisateur
- la consultation de son role et de son email

### 5.4 Gestion des images

Le backoffice permet :

- l'ajout d'une image associee a un post
- le remplacement d'une image existante
- la suppression physique du fichier et de son enregistrement

## 6. Regles de gestion

- un post appartient a un auteur
- un commentaire appartient a un post et a un auteur
- une image appartient a un post
- un commentaire ne peut etre cree que par un utilisateur connecte
- l'acces aux routes `/admin` est reserve aux utilisateurs ayant le role `ROLE_ADMIN`
- le nom d'utilisateur doit etre unique
- l'adresse email doit etre unique
- le mot de passe est stocke de maniere hashee
- les actualites sont affichees par ordre chronologique decroissant

## 7. Exigences non fonctionnelles

- application developpee avec Symfony
- separation claire entre controllers, entites, repositories, formulaires et templates Twig
- site sans CMS
- interface web accessible via une URL publique
- persistance des donnees via Doctrine ORM
- securisation des acces sensibles avec Symfony Security

## 8. Livrables associes

- repository GitHub : `https://github.com/MeritoHassan/merito-hassan-afaris-music-studio`
- application hebergee : `https://studio.afaris.be`
- diagramme de classe : `docs/diagramme-classe.md`
- etat final de rendu : `docs/etat-final-rendu.md`
