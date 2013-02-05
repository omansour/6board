## Events

#### Comment utiliser les events ?

1) Ajouter une constante dans la classe `M6\Bundle\SixBoardBundle\Event\Event`


2) Dispatcher l'event via un `GenericEvent` dans le controller à l'endroit souhaité. Exemple :

    $this->get('event_dispatcher')->dispatch(Events::SUSCRIBE_STORY, new GenericEvent($story));

3) Rajouter dans `M6\Bundle\SixBoardBundle\Listener\NotificationSuscriber` le nouveau event souscrit dans `getSubscribedEvents`

4) Puis créer la fonction qui va permettre d'effectuer ce que tu souhaites
