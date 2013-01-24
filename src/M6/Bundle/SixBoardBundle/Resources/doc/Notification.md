## notification

Au niveau des actions importante (création de demande, ajout de note, ...), il faut ajouter des évenements.

Les notifications seront cablés sur ces évenements.

Il faut faire une many-to-many entre user et milestone|project|story.

Au niveau de la relation il faut mettre les données (jabber, mail, ...), sauf si il y a une meilleur façon de le faire ?

Est-ce qu'il pourra y avoir d'autre mode d'envoi de notification ?

Sur l'évent ajout d'une note et création d'une demande, on doit:
1) Prévenir les abonnées de la milestone
2) Ajouter l'auteur en tant qu'abonné.
