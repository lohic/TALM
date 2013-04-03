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

Wordpress MU sur MAMP CF :

http://perishablepress.com/wordpress-multisite-subdomains-mamp/

SUBLIME VIA TERMINAL (permet d'éditer des fichiers systeme ou via ssh) :

http://www.sublimetext.com/docs/2/osx_command_line.html

POUR INSTALLER WORDPRESS EN MULTISITE :
- créer un dossier « Multisite » dans son dossier utilisateur
- créer le dossier pour son réseau wordpress
- dans MAMP aller dans les réglages d'hôtes
- créer une nouvelle url (par exemple talm.dev)
- sélectionner l'emplacement du dossier dans l'ordinateur
- dans les réglages avancés cocher toutes les options
- dans le terminal ou avec un éditeur ouvrir le fichier /etc/hosts et ajouter la ligne 127.0.0.1 talm.dev
- redémarrer le serveur MAMP avec les ports par défaut (pas les ports MAMP)
- installer wordpress network !
