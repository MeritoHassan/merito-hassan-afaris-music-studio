# Diagramme de classe

Le diagramme ci-dessous decrit la solution cible d'apres les entites et relations actuellement implementees dans le projet Symfony.

```mermaid
classDiagram
    class User {
        +int id
        +string username
        +string email
        +array roles
        +string password
        +bool isVerified
        +datetime createdAt
        +datetime updatedAt
    }

    class Post {
        +int id
        +string titre
        +text contenu
        +datetime dateHeureCreation
        +datetime createdAt
        +datetime updatedAt
    }

    class Commentaire {
        +int id
        +text contenu
        +datetime dateHeureCreation
        +bool signale
        +datetime createdAt
        +datetime updatedAt
    }

    class Image {
        +int id
        +string nomImage
        +string chemin
        +string mimeType
        +datetime dateUpload
        +datetime createdAt
        +datetime updatedAt
    }

    User "1" --> "0..*" Post : publie
    User "1" --> "0..*" Commentaire : redige
    Post "1" --> "0..*" Commentaire : contient
    Post "1" --> "0..*" Image : illustre
```

## Lecture du diagramme

- `User` represente un visiteur inscrit ou un administrateur.
- `Post` represente une actualite publiee sur le site.
- `Commentaire` represente une reaction d'un utilisateur sur une actualite.
- `Image` represente un media associe a une actualite.

## Relations principales

- un utilisateur peut publier plusieurs posts
- un utilisateur peut rediger plusieurs commentaires
- un post peut recevoir plusieurs commentaires
- un post peut contenir plusieurs images

## Remarque

Le projet repose sur quatre entites principales. Les formulaires, controllers et repositories s'appuient sur ce modele pour construire le front office et le backoffice.
