# Site du Tsunami Club 
## Introduction

### Presentation du projet
Cette documentation présente le projet de développement d'un site internet pour le Tsunami Club de Judo. L'objectif principal est de mettre en place une plateforme en ligne moderne et interactive qui répondra aux besoins de la communauté du club. Le site web permettra d'améliorer la communication, simplifier la gestion administrative, promouvoir les actions du club et renforcer les partenariats avec les sponsors. Ce projet vise à offrir une meilleure expérience aux adhérents, aux parents, aux entraîneurs, aux gérants, ainsi qu'aux partenaires et sponsors.
### Specification des besoins
L'application web doit repondre aux besoins suivants:
-  **Automatisation du systeme d'inscription :** 
    Les adhérents doivent pouvoir s'inscrire en ligne et payer leur cotisation via le site web. Les informations des adhérents doivent être stockées dans une base de données. Les documents administratifs ( certificat médical, autorisation parentale, ...) doivent être téléchargeables en ligne. une fiche d'incription doit être générée automatiquement et envoyée par mail au responsable du club.
-  **Gestion des Evenements :** 
    Les événements du club ( compétitions, stages, ...) doivent être affichés sur le site web. Les adherents concernés doivent être notifiés par mail. Les inscriptions aux événements doivent être gérées en ligne et centralisées dans un espace dédié pour une validation par les responsables du club.
-  **Gestion des paiements :** 
    Les paiements des cotisations et des événements doivent être gérés en ligne. Les documents relatifs au paiement ( factures, reçus, ...) doivent être générés automatiquement et envoyés par mail aux adhérents. Un systeme de relance sera mise en place en cas de retard de paiement.
-   **Mise en avant sportive :**
    Afin de mettre en avant les spotifs et le club, un blog ouvert devra etre mis en place avec photo et video des evenements. Le contenue sera soumis a validation avant publication. 
-   **Mise en avant du club :**
    Un espace servant de vitrine sera accessible au public avec la presentation des services et activité du club de judo, acces au calendrier, aux horraires des cours et a leur localisation. Le SEO de cette partie sera optimisé afin de participé au mieux au rayonnement du club.
-   **Une navigation intuitive:**
    Une partie de la cible n'etant pas familier avec le monde du web, la navigation doit etre facilité autant sur mobile que sur grand ecran.
### Specification technique
L'application sera developpé avec les technologie suivantes :
-   **Langage de programmation :**
    Php 8.1 avec le framework Symfony 7.1
-   **Langage front-end:**
    -   Twig 2
    -   HTML
    -   CSS sous la syntaxe SCSS
-   **Base de données :**
    -   MySQL
    -   PhpMyAdmin
-   **Dependance Symfony :**
    -   Webpack encore (Vite ?) ( gestion des assets et compilation du code front-end )
    -   Doctrine ( gestion de la base de données )
    -   Mailer ( gestion des mails )
    -   VinchUploader ( gestion des uploads )
-   **Dependence Javascript :**
    -  Fullcalendar ( gestion du calendrier )
    -  flatpickr.js ( datepicker )
    -  Alpine.js ( gestion des interactions ) ?
    -  Axios ( gestion des requetes http )
    -  Swiper.js ( carousel )
    -  Chart.js ( graphique )
    -  FilePond ( gestion des fichiers )
    -  Anime.js ( animation )
    -  Anime.css ( animation )
    -  simplebar.js ( scrollbar )
    -  pqina ( table )
    -  TinyMCE ( editeur de texte )
    -  tippy.js ( tooltip )
    -  video.js ( video )
    -  Stripe ( paiement )
    -  Paypal ( paiement )
    -  OpenStreetMap ( carte ) ( https://leafletjs.com/ )
    -  cookie.js ( gestion des cookies )
-   **Versionning :**
    -   Git
    -   Github
-   **Documentation :**
    -   Markdown
    -   Mkdocs
-   **Test :**
    -   Phpunit
-   **Gestion de projet :**
    -   Asana ( gestion des taches )
-   **Intégration continue :**
    -   Github Actions
-   **Hébergement :**
    -   Hostinger
-   **Nom de domaine :**
    -   [Tsunami-club-judo.fr]( https://tsunami-club-judo.fr )
-   **Certificat SSL :**
    -   Let's Encrypt
-   **Maquette :**
    -  Figma 
    -  Affinity Suite
### Specification de l'interface










