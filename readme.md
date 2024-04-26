# Guide de mise en marche

## Etape 1:
    Création de la base de données: 

    Tout d'abord rendez dans le fichier '.env' configurer votre "DATABASE_URL"
    Ensuite dans la console effectuer la commande suivante: "symfony console d:d:c"
    Commande suivante: "symfony console d:m:m"

## Etape 2:
    
    Lancer l'application: 

    Tout d'abord ouvrez un terminal et entrée la commande suivante: "npm run watch"
    Par la suite ouvez un deuxième terminal afin de lancer le server: "symfony serve"


### Informations complémentaires:
    
    Concernant le script de l'historique de fonctionnement, il fonctionne bien sur toute les pages
    Il y a plusieurs possiblité, vous pouvez augmenter l'interval du setInterval en modifiant la valeur de la const
    HISTORY_INTERVAL présente ligne 2 de app.js, actuellement toute les secondes.

    Si vous l'augmentez, à chaque changement de page le set interval va être réinitialiser donc l'écart sera bien plus visible
    concernant l'obtention de l'historique pour éviter cela si vous le souhaitez, il suffit de décommenter la ligne 183 de app.js,
    cela permet de générer directement un historique sans attendre 30 secondes entre chaque changement.
