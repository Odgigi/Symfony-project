s'inscrire : dépositaire, fetichiste, évaluateur

# Entités

- User
    - email: string
    - roles: json
    - password: string
    - pseudo: string
    - [statut: json
        - depositaire: D
        - fetichiste: F
        - evaluateur: E]
    - prenom: string
    - nom: string
    + notes: Note
    + fetiche(s): User/Annonce
    + annonces: Annonce

- Annonce
    - titre: string
    - date_creation: date
    - type_article: string
    - matiere: string
    - couleur: string
    - longueur: float
    - largeur: float
    - hauteur: float
    - etat: string
    - histoire: text
    - prix_plancher: float
    - prix_minimum: float
    - prix_moyen: float
    - prix_maximum: float
    - img1: string
    - img2: string
    - img3: string
    - img4: string
    + categorie: Categorie
    + notes: Note
    + collec: Collec
    + fetiche(s): Annonce/User
    + user: User

- Note
    - note_insolite: integer
    - note_pratique: integer
    - note_style: integer

- Categorie
    - nom: string

- Collec
    - nom: string
    - critere: string

1. créer user
2. créer inscription + login
3. créer entités
4. espace admin
5. pages 
    X page de login > login.html.twig
    X page d'inscription > register.html.twig
    X catalogue: affiche toutes les catégories > categorie/index.html.twig 
    X annonces: affiche les annonces dans 1 catégorie > categorie/show.html.twig
    X detail-annonce: affiche en détail 1 annonce + categorie + (collection) + notes + nbre_fétiches + user(dépositaire) > annonce/
    - detail-user: affiche les annonces de chaque statut user:
        - dépositaire: annonces
        - fétichiste: feticheUsers
        - evaluateur: notes
    - contact-user: affiche formulaire de contact vers user



