# Page de contact

Nous allons maintenant ajouter un formulaire de contact à notre site.

Pour répertorier les demandes de contact, il faut voir chaque demande comme une ligne en base de donnée.
Comme demandé dans le cahier des charges, chaque demande de contact est composée des éléments suivants : 
* Nom
* Email
* Objet
* Message

## Création de l'entité Contact

* Utiliser la commande création d'entité `php bin/console make:entity`
* Indiquer comme nom de classe `Contact`
* Les types des propriétés sont les suivants : 
    * Nom : `string`
    * Email : `email`
    * Objet : `string`
    * Message : `text`   
> Avant de créer le CRUD de l'entité `Contact`, pensez à supprimer les fichiers `templates/contact/index.html.twig` et `Controller/ContactController.php`

* Lancer la commande `php bin/console make:crud`
    * Indiquez la classe `Contact` comme objet concerné par le CRUD

