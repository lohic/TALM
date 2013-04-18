TALM
====

Dossier Github pour la plateforme TALM

Faire une installation multsite dans un sous dossier (Sub-directories)
la plateforme définitive est dans un sous domaine (Sub-domains) :
http://codex.wordpress.org/Create_A_Network

Installer les plugins nécessaires :
- Advanced custom field

Installer les thèmes TALM :
- TALM
- TALM pour Tours
- TALM pour Angers
- TALM pour Le Mans

Créer 5 Sous-sites :
- TALM
- Angers
- Tours
- Le Mans
- Etudiants

SUBLIME VIA TERMINAL (permet d'éditer des fichiers systeme ou via ssh) :

http://www.sublimetext.com/docs/2/osx_command_line.html

POUR INSTALLER WORDPRESS EN MULTISITE (en local):
- créer un dossier « Multisite » dans son dossier utilisateur
- créer le dossier pour son réseau wordpress
- dans MAMP aller dans les réglages d'hôtes
- créer une nouvelle url (par exemple talm.dev)
- sélectionner l'emplacement du dossier dans l'ordinateur
- dans les réglages avancés cocher toutes les options
- dans le terminal ou avec un éditeur ouvrir le fichier /etc/hosts et ajouter la ligne 127.0.0.1 talm.dev
- redémarrer le serveur MAMP avec les ports par défaut (pas les ports MAMP)
- installer wordpress network !

Wordpress MU sur MAMP CF :

http://perishablepress.com/wordpress-multisite-subdomains-mamp/

Notes AJAX & wordpress :

- http://wordpress.stackexchange.com/questions/90221/jquery-load-php-php-file-without-the-template
- http://codex.wordpress.org/Plugin_API/Action_Reference/wp_ajax_(action)
- http://www.1stwebdesigner.com/css/implement-ajax-wordpress-themes/
- http://www.wp-themix.org/wordpress/how-to-add-a-jquery-ajax-contact-form-to-wordpress/
- http://www.garyc40.com/2010/03/5-tips-for-using-ajax-in-wordpress/
- http://wordpress.org/support/topic/ajaxurl-is-not-defined
- http://wordpress.stackexchange.com/questions/22256/how-wp-ajax-nopriv-since-wordpress-3-1
- http://www.natedivine.com/web-development/difference-wp_ajax-wp_ajax_nopriv/
- *** http://codex.wordpress.org/AJAX_in_Plugins
- https://codex.wordpress.org/Class_Reference/WP_Query
