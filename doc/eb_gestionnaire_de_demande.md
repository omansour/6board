# EB gestionnaire de demandes

(mes excuses pour mon orthographe déplorable)

Gestionaire de demandes (anomalie, évolutions fonctionnelles …) sur des projets informatiques.

* outil en mode web
* persistence mysql
* n'importe quel langage (PHP est mieux)

**Par rapport aux bugtrackers classiques, le point le plus dur semble être mon besoin de pouvoir prioriser les tickets entre eux.**


## données

### projets et groupe de projets

Un projet contient des demandes (voir plus bas). Un projet appartient à zero ou 1 groupe de projets.

### demandes

Une demande contient: 

* un numéro (généré)
* un titre 
* une description
* un type (liste configurable par projet)
* un statut (liste configurable par projet) avec au min : nouveau - validé - en cours - fermé
* un motif de fermeture (optionel, liste par projet)
* une date d'ouverture
* une date de fermeture (optionnelle)
* un utilisateur rapporteur 
* un utilisateur assigné (optionnel)
* n fichiers (optionnel)
* n notes (optionnel)
* une "due date" (optionnelle)

### milestone

Une milestone contient une date de fin, un projet, un état (ouvert, fermé).

### utilisateurs

* nom 
* prenom 
* email
* téléphone (optionel)
* id jabber (optionnel)

la vérification du mot de passe se fait sur le LDAP.


## logging

Toutes les modifications sont logguées et horodatées dans les notes des demandes (qui, quand, quoi). (y compris création et chaque changement sur chaque champs, on peut imaginer typer les notes pour distinguer )

## tableaux de suivis

L'interface principale est un tableau de demandes. 

suivi / priorisation

### tableau de priorisation

#### filtrage possible 
* par groupe de projets
* par projet

#### tableau

Selon le filtrage on peut trier les demandes entre elles. 

Sur un projet, les demandes sont triées du plus au moins prioritaire puis celles qui ne sont pas priorisées (code couleur ?)
Sur un groupe de projet, les demandes sont tries du plus au moins prioritaire dans le groupe de projet, puis au sein de chaque projet, puis celles qui ne sont pas priorisées.

(il y a un système de classement différent par projet et groupe de projet)

### tableau de suivi

#### filtrage possible
* par groupe de projets
* par projet 
* par milestone
* par statut
* par type 
* par rapporteur 
* par utilisateur assigné (ceux avec personne aussi)

On peut enregistrer un filtrage, lui donner un nom, et le rappeler d'un clic.

#### tableau

La liste présente un synthèse des demandes. Un clic emmene vers l'édition de la demande.

## recherche

* sur numéro de demande 
* plein texte sur le reste 
* filtres idem que tableau de suivi

## reporting

### à date

#### filtrage possible

* idem filtrage suivi

#### listes des rapports

* liste des demandes ouvertes approchant la "due date" (approchant … à voir ?)
* liste des demandes dépassant la "due date"
* liste des demandes ouvertes depuis plus de x jours 
* liste des demandes avec plus de x notes 
* liste des demandes réouvertes

*TODO* 

### reporting hebdomadaire

#### filtrage possible
* par groupe de projets
* par projet
* par type (tous possible)
* par utilisateur assigné

#### résultats
sur une semaine, un mois, une année

* demandes ajoutées
* demandes fermées
* temps médian de traitement
* nombre de demandes ré-ouvertes (passées en fermées mais toujours en non fermées) (?)


## droits

(simpliciste)

Une interface pour chaque utilisateur pour gérer accès à projet et groupe de projet (pas d'héritage) et le droit à l'accès au tableau de priorisation.

## notification

trigger : à chaque modification d'une demande ou ajout d'une note

Possibilité de s'abonner volontairement (mail ou jabber) : 

* à un projet et sous projet 
* à une demande
* à une milestone

Une action sur une demande auto abonne l'utilisateur.


## API

une API permettant d'ajouter une note à une demande via son numéro.