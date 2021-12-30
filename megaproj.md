aCréation du site MEGAPROJ ds terminal

Personnes qui peuvent s'inscrire: écrivain, évaluateur, critique

# ENTITES

- User
    - email: string
    - password: string
    - role: json
    - favoris: production[]
    + commandes: Commande[]

- ProfilEstimateur
    - utilisateur: user
    - resume: string
    - isValidated: boolean

<!-- - DemandeValidation
    - estimateur: user
    - createdAt: DateTimeImmutable -->

- profilAcheteur
    - utilisateur: user
    - adresse: string
    - ville: string
    - zipcode: string

- Devis
    - auteur: User
    - demande: text
    - email: string
    - phone: string
    - reference: string
    - prix: float

- Categorie
    - titre: string
    - description: text
    + productions: production[]

- Production
    - categorie: Categorie
    - auteur: User
    - contenu : text
    - prixFinal: float
    + estimations: Estimation[]
    + critiques: Critique[]

- Estimation
    - production: production
    - estimateur: User
    - prix: float

- Critique
    - production: production
    - critique: User
    - commentaire: text
    - note: integer

- CommandeDetail
    - production: Production
    - quantité: integer
    + commande: commande

- Commande
    - acheteur: User
    - prixTotal: float
    - details: CommandeDetail[]
    - paye: boolean
    - createdAt: DateTimeImmutable
    - paidAt: DateTimeImmutable

1. créer user
2. créer l'inscription + login
3. créer mes entités
4. espace admin
5. refléchir aux pages
    X page de login
    X page d'inscription
    X catalogue: affiche toutes les catégories
    X productions: affiche en détail les productions dans 1 catégorie
    X detail-production: affiche en détail 1 production + critiques + notes + estimations
    X auteurs: affiche tous les auteurs
    X detail-auteur: liste des productions d'un auteur
    X critiques: affiche tous les critiques
    X estimateurs: affiche tous les estimateurs
    X demande-devis: affiche un formulaire de demande de devis
    X favoris: liste des favoris
    X profil: pour modifier ses infos
    X commandes: liste des commandes passées

Config twig.yalm:
    - Kernel
    - theme bootstrap

# navbar dans navbar.html.twig > include dans base.html.twig;

path vers home page : {{ path('home') }} dans navbar.html.twig
{{ path('categorie_index') }} / {{ path('admin_categorie_index') }}
{{ path('production_index') }} / {{ path('admin_production_index') }}
{{ path('commande_index') }} / {{ path('admin_commande_index') }}
{{ path('devis_index') }} / {{ path('admin_devis_index') }}
{{ path('user_index') }} / {{ path('admin_user_index') }}
dans user Controller: route("/{type}", name "user_index', {type/)

dans show.html.twig: 
{{ categorie.titre }}
{{ categorie.description }}
{% for production in categorie.productions %}<h2>{{ production.titre }}</h2>
<a href="{{ path('production_show', {'id': production_id}) }}">Voir le contenu</a>
<a href="{{ path('estimation_new') }}">Estimer</a>
<a href="{{ path('critique_new'), {'id':production.id}) }}">Commenter</a>
<a href="{{ path('favoris_add', {'id':production.id}) }}">En favoris</a>

Favoris : route sans page

ProductionController:
@Route("/add/{id}", name="favoris_add", methods="{GET})
public function favoris(Production $production): Response
$user = $this->getuser();
/** @var App\Entity\User $user */
$user->addFavori($production);
$entityManager = $this->getDoctrine()->getManager();
$entityManager->flush();

PanierController.php
/**
*@Route("/panier", name="panier")
*/
public function index(SessionInterface $sessionInterface): Response
{
    $panier = $sessionInterface->get('cart');
    return $this->render('panier/index.html.twig', [
        'panier' => $panier,
    ]);
}
Panier:
<a href="{{ path('panier_clear') }}">Nettoyer mon panier :8</a>
<a href="{{ path('payment') }}">Payer maintenant</a>



