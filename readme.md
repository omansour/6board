# EB gestionnaire de demandes

(mes excuses pour mon orthographe déplorable)

Gestionaire de demandes (anomalie, évolutions fonctionnelles …) sur des projets informatiques.

* outil en mode web
* persistence mysql
* n'importe quel langage (PHP est mieux)

**Par rapport aux bugtrackers classiques, le point le plus dur semble être mon besoin de pouvoir prioriser les tickets entre eux.**

## priorités

1/ doctrine
2/ formulaire de filtrage (avec enregistrement en session et GET)
3/ route de priorisation et priorisation dans la liste
4/ trigger
5/ poser le routing

## menu et navigation

###  menu

* home
* quicklinks (les filtrages enregistrés)
* priorisation (selon un droit)
* calendar
* reporting
* timeline

### home

=> c'est l'accès aux tableaux de suivi.

par défaut, sans filtrage, on accède au ticket affecté à l'utilisateur courant.


## données

### projets et groupe de projets

Un projet contient des milestones qui contiennent des demandes/story (voir plus bas).

### demandes

Une demande contient:

* un numéro (généré)
* un titre
* une description
* un type : major, minor, alert, feature
* un statut : new, valid, in progress, closed
* un motif de fermeture : resolved, invalid, wont be resolved, duplicate, unreproducible
* une date d'ouverture
* une date de fermeture (optionnelle)
* un utilisateur rapporteur
* un utilisateur assigné (optionnel)
* n fichiers (optionnel)
* n notes (optionnel)
* une "due date" (optionnelle)
* une liste de tags

une demande peut être liée à n autres demandes.

### milestone

Une milestone contient une date de fin, un projet, un état (ouvert, fermé).

En config, on peut préciser des milestones qui sont automatiquement ajoutées lors de l'ajout de milestone à une story (l'ajout d'une milestone a une story ajoute automatiquement celle précisée en config) (ce n'est pas valable pour la supression).

### utilisateurs

* nom
* prenom
* email
* téléphone (optionel)
* id jabber (optionnel)

la vérification du mot de passe se fait sur le LDAP. => FOSUserBundle

## logging

Toutes les modifications sont logguées et horodatées dans les notes des demandes (qui, quand, quoi).

Il est impossible de supprimer une note.

## edition des projets et milestone

crud sur les projet et les milestones

## tableaux de suivis

L'interface principale est un tableau de demandes.


### tableau de priorisation

il faut choisir une milestone.

#### filtrage possible sur le tableau de priorisation
* par nom de milestone
* on exclu les milestones fermées

les demandes sont toutes affichées sauf celle fermées.

#### tableau de priorisation

Une fois une milestone choisie on peut trier les demandes entre elles.

un raccourci permet de prioriser une demande en top priorité.

### tableau de suivi

#### filtrage possible
* par projet (plusieurs possibles)
* par milestone (plusieurs possibles)
* par statut (plusieurs possibles)
* par type (plusieurs possibles) ?
* par rapporteur (plusieurs possibles) ?
* par utilisateur assigné (ceux avec personne aussi) (plusieurs possibles)
* sur numéro de demande
* plein texte sur le titre puis la description puis un tag

On peut enregistrer un filtrage, lui donner un nom, et le rappeler d'un clic. Les recherches enregistrés sont présentes dans le menu. Ce menu contient par défaut une recherche sur les bugs ouverts par moi et une recherche sur les bug qui me sont assignés.

#### tableau

La liste présente un synthèse des demandes.

est présenté :

* le numéro de la demande
* le titre
* la milestone
* le projet
* J-x si il y a une due date (J+ possible) *code couleur*

Un clic sur le numéro emmene vers l'édition de la demande.

Le tableau est trié par Milestone (séparation visuelle) et priorité.


## navigation

Chaque filtrage est enregistrée en session. la recherche se fait en GET (pour pouvoir partager cette recherche) - faut être malin sur l'encodage de la recherche ;) . On peut enregistrer en base n'importe quelle recherche en lui donnant un nom. Cette recherche est restreinte à l'utilisateur. Il peut la passer en publique ; elle apparait alors dans le menu recheche de l'utilisateur.

## reporting

### à date

à la date de lancement du rapport.

#### filtrage possible

* idem filtrage suivi

#### listes des rapports

* liste des demandes ouvertes approchant la "due date" (approchant. valeur par défaut configurable)
* liste des demandes dépassant la "due date"
* liste des demandes ouvertes depuis plus de x jours (x valeur configurable)
* liste des demandes avec plus de x notes (x valeur configurable)
* liste des demandes réouvertes (qui sont passées au statut fermé mais qui ne sont pas actuellement au statut fermé) *pas facile ?*


### reporting hebdomadaire

il faut choisir une semaine, un mois, une année

choisir deux dates ?

#### filtrage possible
* par projet
* par type (tous possible)
* par utilisateur assigné

#### résultats
sur une semaine, un mois, une année

* demandes ajoutées
* demandes fermées
* temps médian de traitement
* nombre de demandes ré-ouvertes (passées en fermées mais toujours en non fermées) *pas facile ?*

## droits

(simpliciste)

Les utilisateurs accèdent à tous les projets et peuvent tout faire dessus.

Un droit existe pour donner l'accès à l'interface de priorisation.
Un droit existe pour donner l'accès à l'interface de crud (projets/milestone).

## notification

trigger : à chaque modification d'une demande ou ajout d'une note

Possibilité de s'abonner volontairement (mail ou jabber) (suivre) :

* à une demande
* à une milestone

L'ajout d'une demande à un milestone entraine une notification spécifique aux utilisateurs abonnés à la milestone.

Une action sur une demande auto abonne l'utilisateur.

On peut se desabonner d'un ticket spécifique (en allant dessus).

(projet ? milestone ?)


## API

une API permettant d'ajouter une note à une demande via son numéro.

## routing

(?)

* /
* /story/view/<id>
* /story/edit/<id>
* /list/...
* /sort/...
* /search
* /project (?)
* /user/view/<id>
* /user/list
