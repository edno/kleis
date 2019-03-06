# Kleːs - [![Release](https://img.shields.io/github/release/edno/kleis.svg?style=flat-square)]() [![Build Status](https://img.shields.io/travis/edno/kleis.svg?style=flat-square)](https://travis-ci.org/edno/kleis) [![Code Quality](https://img.shields.io/scrutinizer/g/edno/kleis.svg?style=flat-square)](https://scrutinizer-ci.com/g/edno/kleis/) [![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fedno%2Fkleis.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fedno%2Fkleis?ref=badge_shield)

Kleis est un gestionnaire d'utilisateurs et groupes pour proxy de type Squid. Il permet aussi de gérer une liste blanche pour le filtre SquidGuard.
Kleis maintient à jour la liste de vos utilisateurs et leur appartenance à un groupe, dans une base de données. Il est ensuite possible d'exporter ces informations sous forme de fichiers plats pour être intégrés à la configuration de Squid et de SquidGuard.

Ainsi, pour une gestion évoluée d'un ensemble d'utilisateurs de votre proxy, vous n'avez pas la nécessité d'utiliser un annuaire LDAP.

Kleis exporte les fichiers suivants :
- Fichier de mot de passe, de type htaccess, tel qu'utilisé par Squid dans ce mode d'authentification
- Fichiers de categories (par exemple, mineur, majeur, salarié, professeur...), pour être utilisés dans SquidGuard
- Fichiers de groupes (les groupes sont gérés par des gestionnaires de groupes), pouvant également être utilisés dans SquidGuard
- Fichiers de liste blanche (domaines complets ou URLs), destiné à être ajoutés aux listes que vous utilisez avec SquidGuard

Il n'est pas nécessaire de disposer de Squid et SquidGuard sur le même serveur que Kleis. Peu importe votre mise en oeuvre, il vous faudra à un moment positionner les fichiers générés par Kleis aux bons endroits. Un exemple d'intégration est donné dans la documentation de Kleis.

## Installation
Voir [installation](https://github.com/edno/kleis/wiki/Installation) dans le Wiki.

## Intégration avec Squid et SquidGuard

Ce qui suit suppose que vous disposiez d'une installation Squid, couplée à SquidGuard fonctionnelle. Vous devriez avoir quelque chose comme
`auth_param basic program /usr/lib/squid3/basic_ncsa_auth /etc/squid3/passwords``
dans votre fichier squid.conf.

### Exporter les fichiers

**Kleis** permet d'exporter les fichiers utiles par le lancement d'une commande. Les commandes suivantes :
```shell
cd /var/www/kleis
php artisan export:accounts
php artisan export:categories
php artisan export:groups
php artisan export:whitelist
```
génèrent respectivement les comptes utilisateurs, les catégories, les groupes, et les fichiers de liste blanche. Ces fichiers sont générés dans ``/var/www/kleis/storage/app/export/``, vous devez donc rendre ce repertoire modifiable par l'utilisateur. Dans la suite de l'exemple nous n'utilisons pas les groupes.

Il faut ensuite déplacer les fichiers aux bons endroits :
```shell
cp /var/www/kleis/storage/app/export/accounts/accounts.txt /etc/squid3/passwords
cp /var/www/kleis/storage/app/export/categories/*.txt /var/lib/squidguard/db/
cp /var/www/kleis/storage/app/export/proxylists/*.txt /var/lib/squidguard/db/
```

Vous devriez à ce moment là mettre à jour les blacklists de SquidGuard. Une fois cela fait, regénérez les bases de SquidGuard puis relancez Squid :
```shell
squidGuard -C all
/usr/sbin/service squid3 restart
```

### Points d'attention

Que vous fassiez l'intégration manuellement ou que vous utilisiez un ordonanceur (la crontable ou jenkins par exemple), vous devez veiller aux droits des différents fichiers :
- Le fichier password doit appartenir à l'utilisateur proxy. Pour ne pas changer cela, vous pouvez ajouter l'utilisateur de votre ordonanceur au groupe proxy, et rendre le fichier des mots de passe modifiable par le groupe.
- Les fichiers de groupe et whitelist ont les mêmes besoins. Cela est particulièrement important : si l'utilisateur du proxy ne peut pas correctement lire les fichiers, alors SquidGuard entrera en mode "Emergency", laissant passer l'intégralité du trafic.
- Pour redémarer squid3 via la commande service, vous devriez utiliser sudo. L'usage d'autres scripts pour relancer Squid pourrait modifier les propriétaires et les droits de fichiers, et empêcher une mise à jour par votre utilisateur d'ordonnanceur.


## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fedno%2Fkleis.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fedno%2Fkleis?ref=badge_large)

## Thanks for support
[![BrowserStack](https://dgzoq9b5asjg1.cloudfront.net/production/images/static/header/header-logo.svg)]([https://live.browserstack.com])
