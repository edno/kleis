# Kleis

Kleis est un gestionnaire simplifié pour proxy.

## Pré-requis

La procédure d'installation décrite est pour un environnement **Debian**.

Toute les commandes sont données pour un utilisateur avec des droits de type `root`.

### Git (optionnel)

L'installation de Git est nécessaire uniquement pour déployer **Kleis** depuis GitLab.

Executer la commande:
```shell
apt-get install git
```

### MySQL

Installer **MySQL Server** avec la commande:
```shell
apt-get install -y mysql-server mysql-client
```

Sécuriser l'installation (accepter `Y` toutes les questions)
```shell
mysql_server_secure
```

Se connecter au serveur MySQL avec les identifiant du compte `root`
```shell
mysql -u<login-mysql-root> -p<mot-de-passe-mysql-root>
```

Créer la base de données `kleis`
```mysql
create database kleis;
exit
```

### Apache

Installer **Apache** avec la commande:
```shell
apt-get install -y apache2
```

Activer le module `rewrite`:
```shell
a2enmod rewrite
```

### PHP5

Installer **PHP5** et ses modules avec la commande:
```shell
apt-get install -y php5 php5-mysql
```

Cette installation suffit à satisfaire les [pré-requis](https://laravel.com/docs/5.1/installation#installation) du framework **Laravel 5** sur lequel est construit **Kleis**.

Redémarrer le service Apache
```shell
service apache2 restart
```

### Composer
**Composer** est le gestionnaire de paquets pour PHP utilisé par `Kleis`.

Installer Composer avec la commande suivante:
```shell
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=bin --filename=composer
php -r "unlink('composer-setup.php');"
```


## Déploiement

### Installation des sources

2 options pour l'installation des sources:

#### 1- Package Tar Gz
Extraire l'archive `kleis` dans le répertoire `/var/www/`:
```shell
tar -xzf kleis-*.tar.gz --directory /var/www/
```
Renommer le repertoire ainsi créé en `kleis` 
```shell
mv /var/www/kleis* /var/www/kleis
```

#### 2- GitLab
Cloner le projet `kleis` depuis **GitLab**:
```shell
cd /var/www
git clone https://gitlab.com/edno/kleis.git
```

### Installation des dépendances

A partir de cette étapes, l'ensemble des commandes doivent être exécutées depuis le répertoire d'installation de **Kleis** :
```shell
cd /var/www/kleis
```

Installer les dépendances en utilisant la commande `install` de **Composer** :
```shell
php composer install
```

### Configuration

Créer le fichier `.env` qui hébergera la configuration:
```
cp .env.example .env
```

Editer le fichier `.env` et adatper les paramètres suivants:

| Paramétre | Description |
|-----------|-------------|
| `APP_URL`   | URL de l'application, par exemple `http://kleis.app:8080` |
| `DB_DATABASE` | Base de données de l'application : `kleis` |
| `DB_USERNAME` | Utilisateur ayant accès en lecture-écriture à la base de données `DB_DATABASE` |
| `DB_PASSWORD` | Mot de passe pour l'utilisateur `DB_USERNAME` |

Générer la clef unique de l'application
```
php artisan key:generate
```

### Permission des répertoires

Changer les permissions des repertoires de **Kleis**
```shell
chown -R www-data:www-data /var/www/kleis
chmod -R 755 /var/www/kleis
```

### Tables de la base de données
Installer les tables dans la base de données :
```shell
php artisan migrate --seed
```

### Site Apache

Cette étape considère que seule l'application **Kleis** est hébergée par le serveur **Apache**.

Installer le fichier de configuration `kleis.conf`
```shell
cp kleis.conf /etc/apache2/sites-available/
```

Désactiver le site par défaut
```shell
a2dissite 000-default
```

Activer **Kleis**
```shell
a2ensite kleis
```

Redémarrer le service `apache2`
```shell
service apache2 restart
```

## Fin

**Kleis** est maintenant installé et accessible :
- `http://localhost`
- `http://<nom-du-serveur>`
- `http://<ip-du-server>`

La première connexion se fait avec le compte super administrateur par défaut :
- email : `admin@kleis.app`
- mot de passe : `admin`
