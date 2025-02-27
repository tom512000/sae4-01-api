# SAE 4-01 | Back

## 💼 Sujet
Gestion des stages et alternances d'une formation : Cette application sera utilisée par des étudiants et des administrateurs. Il s'agit de gérer pour chaque proposition de sujet de stage ou d'alternance, les informations nécessaires telles que le lieu, les technologies (tags) et l'entreprise. L'application doit par ailleurs gérer l'inscription des étudiants intéressés à un stage ou une alternance. Les étudiants peuvent consulter la liste des stages ou alternances compléte ou la liste de stages ou alternances sélectionnés. Les administrateurs peuvent consulter la liste des étudiants intéressés par un stage ou une alternance et ils gérent la liste des des stages ou alternances pourvus.

## 👥 Auteurs
- 👤 Valentin CLADEL - <span style="color: purple">clad0006</span>
- 👤 Baptiste SIMON - <span style="color: purple">simo0170</span>
- 👤 Tom SIKORA - <span style="color: purple">siko0001</span>

## 📝 Notes
- Identifiant : `pc-client-sae4-01`
- Mot de passe : `pc-client`
- Adresse IP : `10.31.33.97`
- Site : http://10.31.33.97:8080/

## 🛠 Installation et Configuration
### *<span style="color: orange">1. Installation</span>*
Mettre à jour votre dépôt local :
- `git clone https://iut-info.univ-reims.fr/gitlab/clad0006/sae-4-01-api.git`
- `cd <dépôt_local>`
- `git pull`

Ensuite, dans le répertoire de votre projet, vous devez <span style="color: orange">installer les composants nécessaires</span> au fonctionnement du projet :
- `composer install`

Finalement, <span style="color: orange">reconfigurez votre accès à la base de données</span> en redéfinissant le fichier « .env.local » :
- `DATABASE_URL="mysql://clad0006:clad0006@mysql:3306/clad0006_sae3?serverVersion=mariadb-10.2.25&charset=utf8"`

### *<span style="color: green">2. Instructions de push</span>*
Lorsque vous avez terminé une tâche, <span style="color: green">resynchronisez votre dépôt distant</span> grâce aux commandes suivantes :
- `git branch <branche>`
- `git checkout <branche>`
- `git commit -m "message-commit"`
- `git push --set-upstream origin <branche>`

Ensuite, sur GitLab, <span style="color: green">créez un merge-request</span> sur votre branche et <span style="color: green">assignez un membre du projet</span> à la revue et à la validation.

### *<span style="color: red">3. Site et navigation</span>*
Pour lancer le site, assurez-vous d'être <span style="color: red">connecté au VPN</span>.
Ensuite, lancez le serveur de test avec la commande suivante :
- `composer start`

Accédez à l'url du site : https://127.0.0.1:8000/api.
Tant que vous ne vous connectez pas, vous ne pourrez accéder qu'à la page d'accueil.
Si vous tentez de naviguer sur une autre page, vous serez automatiquement redirigé vers <span style="color: red">le formulaire de connexion</span>.

Depuis ce formulaire, vous pouvez vous connecter avec votre adresse email et votre mot de passe créés précédemment.
Vous pouvez également vous connecter avec le compte administrateur de test :
- Adresse Email : <span style="color: red">valentin.cladel@gmail.com</span>
- Mot de passe : <span style="color: red">test</span>

Vous pouvez créer un compte :
- Cliquez sur "S'inscrire" pour accéder à la page de création de compte.
- Remplissez les informations (Adresse Email, Mot de passe, Nom, Prénom, Numéro de téléphone, Date de naissance, un CV et une lettre de Motivation si nécessaire).
- Cliquez sur "Sauvegarder" pour valider la création du compte et l'enregistrer dans la base de données.
- Vous pouvez maintenant vous connecter.

Une fois connecté, vous avez accès au site et vous pouvez consulter :
- Les offres
- Les offres récentes
- Les détails d'une offre
- Les entreprises
- Les détails d'une entreprise
- Les offres d'une entreprise
- La page de profil
- La page de modification du profil
- La page de supression du profil
- La page d'inscription
- Le tableau de bord (si vous êtes administrateur)
- La page à propos de nous
- La page des conditions générales d'utilisation
- La page des mentions légales

Ces différentes pages sont accessibles via la barre de navigation ou le pied de page.
Pour accéder à la page d'accueil depuis une autre page, il suffit de cliquer sur le texte <span style="color: red">EduTech</span> ou le <span style="color: red">logo d'EduTech</span> dans la barre de navigation.

## 📐 Scripts
- `composer start` : Lance le serveur web de test.
- `composer stop` : Arrête le serveur web de test.
- `composer test:cs` : Lance la commande de vérification du code par PHP CS Fixer.
- `composer fix:cs` : Lance la commande de correction du code par PHP CS Fixer.
- `composer test:codeception` : Nettoie le répertoire « _output » et le code généré par Codeception, initialise la base de données de test et lance les tests de Codeception.
- `composer test` : Teste la mise en forme du code et lance les tests avec Codeception.
- `composer db` : Détruit et recrée la base de données, migre sa structure et regénère les données factices.

## 💻 Création de la VM
### 1) Création de votre machine virtuelle dans OpenNebula
1. Accès à l'interface Web du cloud [OpenNebula](http://one-frontend:9869/).
2. Connexion avec notre compte universitaire pour accéder à notre tableau de bord.
3. Ajout d'une nouvelle machine virtuelle.
4. Choix du modèle "template".
5. Sélection du modèle "TP Install Ubuntu".
6. Saisie du nom de la machine "VM-SAE4-01" avec une taille de disque dur de 25GB.
7. Le second lecteur de notre machine virtuelle permet de selectionner la taille de l'image ISO du DVD de Fedora.
8. Le bouton "Create" permer de créer et lancer le déploiement de la machine virtuelle.
9. Le voyant orange montre que la machine virtuelle est en cours de déploiement, selection du nom de la machine virtuelle.
10. Affichage des détails de notre machine virtuelle qui indiquent son stade de déploiement.
11. Attendre le déploiement complet de la machine virtuelle ("RUNNING" ou voyant vert).
12. Sélection du boutton d'affichage de la machine virtuelle.
13. Lancement de l'installation de la distribution Ubuntu.
14. Augmentation de la résolution de l'écran virtuel et poursuite de l'installation.
15. Commencement de l'installation de notre distribution Linux.

### 2) Utilisation de « Remote Viewer » pour accéder à votre machine virtuelle OpenNebula
1. Téléchargement de la machine vituelle.
2. Lancement de la machine virtuelle en format **.vv**
   - Soit en double-cliquant sur le fichier "VM-SAE4-01.vv".
   - Soit dans un terminal avec la commande :
```bash
$ remote-viewer repertoire/ou/est/rangé/le/fichier/VM-SAE4-01.vv
```

### 3) Installation d'une distribution Xubuntu
1. Choix de lancer la distribution en live CD ou de démarrer directement l'installation.
2. Sélection de "Français" puis sélection d'"Installer Xubuntu".
3. Sélection de la disposition du clavier en "French".
4. Désactivation des mises à jour pendant l'installation.

### 4) Configuration des partitions de stockage
1. Choix du type d'installation afin d'organiser notre disque dur pour accueillir le système d'exploitation Ubuntu.
2. Sélection de "Nouvelle table de partition".
3. Confirmation et initialisation du système de partitionnement du disque.
4. Création des partitions :
   - Partie 1 : Taille 500 Mo, primaire, système de fichiers "ext4" et un montage en /boot.
   - Partie 2 : Taille 1500 Mo, primaire, utilisé comme "espace d'échange" et un montage en swap.
   - Partie 3 : Taille 15000 Mo, type logique, système de fichier "ext4" et un montage en /.
   - Partie 4 : Taille espace restant, type logique, système de fichier "ext4" et un montage en /home.
5. Validation de notre système de partitionnement.
6. Choix de notre fuseau horaire à Paris.
7. Renseignement des informations de l'utilisateur de notre système :
   - Nom : pcclientsae301-KVM
   - Nom de notre ordinateur : pc-client-sae4-01
   - Nom d'utilisateur : pc-client-sae4-01
   - Mot de passe : pc-client
8. Démarrage de l'installation.
9. Sélection de "Redémarrer maintenant".
10. Sélection de la touche "Entrer".
11. Redémarrage de la machine virtuelle sur Xunbuntu.
12. Première connexion.

## 🧰 Création du serveur Apache
### 1) Gestion des services : `systemd`
1. `sudo apt-get install openssh-server` : Installation du paquet sshd.
2. `ssh localhost` : Vérification du démarrage du service sshd.
3. `exit` : Déconnexion.
4. `sudo systemctl stop ssh` : Arrêt du service sshd.
5. `ssh localhost` : Reconnexion.
6. `sudo systemctl start ssh` : Redémarrage du service sshd.

### 2) Serveur Web apache2
1. `sudo apt-get install apache2` : Installation du paquet apache2.
2. `sudo apt-get upgrade` : Mise à jour de tous les paquets installés sur le système.
3. `sudo apt-get update` : Mise à jour des informations de dépôt de paquets sur le système.
4. `sudo service apache2 start` : Démarrage du service apache2.
5. Vérification du bon fonctionnement du serveur Web (http://localhost/).
6. `sudo a2enmod userdir` : Activation des pages d'accueil des utilisateurs à l'aide du module userdir.
7. `sudo service apache2 restart` : Redémarrage du service apache2.
8. `mkdir sae4-01` : Création du répertoire qui va contenir le front et le back.
9. `git clone https://iut-info.univ-reims.fr/gitlab/clad0006/sae-4-01-api.git` : Clonage du dépôt git de notre projet dans le répertoire d'accueil de l'utilisateur.
10. `composer install` : Installation de composer pour notre projet.
11. `sudo touch ~/sae4-01/sae-4-01-api/.env.local` : Création du fichier de connexion à la base de données.
12. `sudo evim ~/sae4-01/sae-4-01-api/.env.local` : Ajout de la ligne `DATABASE_URL="mysql://clad0006:clad0006@mysql:3306/clad0006_sae3?serverVersion=mariadb-10.2.25&charset=utf8"`.
13. `sudo chown www-data:www-data ~/sae4-01/sae-4-01-api/` : Attribution des droits d'accès à l'utilisateur du serveur Web www-data pour le répertoire sae-4-01-api.
14. `sudo chmod 755 ~/sae4-01/sae-4-01-api/` : Affectation des droits par défaut pour le répertoire sae-4-01-api.
15. `sudo ln -s $HOME/sae4-01/sae-4-01-api/ /var/www` : Création d'un lien symbolique de notre projet vers l'arborescence /var/www.
16. `nslookup 10.31.33.47` : Récupération du nom DNS de notre machine virtuelle.
17. `sudo evim /etc/hosts` : Modification du fichier /etc/hosts.
    ```bash
    127.0.0.1    localhost
    127.0.0.1    2A4V3-31UVM0303.ad-urca.univ-reims.fr
    
    # The following lines are desirable for IPv6 capable hosts
    ::1     ip6-localhost ip6-loopback
    fe00::0 ip6-localnet
    ff00::0 ip6-mcastprefix
    ff02::1 ip6-allnodes
    ff02::2 ip6-allrouters
    ```
18. `sudo touch /etc/apache2/sites-available/pc-client-sae4-01.conf` : Création du fichier de configuration du serveur.
19. `sudo evim /etc/apache2/sites-available/pc-client-sae4-01.conf` : Modification du fichier de configuration pc-client-sae4-01.conf.
    ```bash
    <VirtualHost *:80>
        ServerName http://2A4V3-31UVM0303.ad-urca.univ-reims.fr
            ServerAdmin webmaster@localhost
        DocumentRoot /var/www/sae4-01/sae-4-01-api/public
    
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    
        <Directory /var/www/sae4-01/sae-4-01-api>
            Options FollowSymLinks MultiViews
                    AllowOverride None
                    Order allow,deny
                    allow from all
            </Directory>
    </VirtualHost>
    ```
20. `sudo a2ensite /etc/apache2/sites-available/pc-client-sae4-01.conf` : Activation du site.
21. `sudo touch /etc/apache2/conf-available/serveur.conf` : Création d'un fichier de configuration du serveur.
22. `sudo evim /etc/apache2/conf-available/serveur.conf` : Modification du fichier de configuration du serveur.
    ```bash
    <Directory /var/www/sae4-01/sae-4-01-api/public>
        Options Indexes FollowSymLinks
        AllowOverride None
        DirectoryIndex /sae4-01/sae-4-01-api/index.php
        FallbackResource /sae4-01/sae-4-01-api/index.php
    </Directory>
    Alias "/sae4-01/sae-4-01-api" "/var/www/sae4-01/sae-4-01-api/public"
    ```
23. `sudo a2enconf /etc/apache2/conf-available/serveur.conf` : Activation de la configuration.
24. `sudo apache2ctl configtest` : Vérification des configurations "Syntax OK".

### 3) Langage de programmation PHP
1. `sudo apt-get install php` : Installation du paquet php.
2. `sudo apt-get install libapache2-mod-php` : Installation du paquet libapache2-mod-php.
3. `sudo evim /etc/apache2/mods-enabled/php8.3.conf` : Modification du fichier php8.3.conf.
    ```bash
    ...
    # <IfModule mod_userdir.c>
    #     <Directory /home/*/public_html>
    #         php_admin_flag engine Off
    #     </Directory>
    # </IfModule>
    ```
4. `sudo service apache2 restart` : Redémarrage du serveur.
5. Vérification de l'accès à la page du site (http://10.31.33.97).
