#! /bin/bash

export DEBIAN_FRONTEND=noninteractive

apt-get update -qq
#apt-get install -y php5 php-apc php5-cli php5-intl php5-curl php5-gd php5-imagick php5-mcrypt php5-mysql php5-sqlite php5-xdebug php5-xmlrpc php5-xsl php-pear
apt-get install -y php5-fpm php-apc php5 php5-cli php5-intl php5-curl php5-gd php5-imagick php5-mcrypt php5-mysql php5-sqlite php5-xdebug php5-xmlrpc php5-xsl php-pear
apt-get install -y mysql-server-5.5 openssl libssl-dev nodejs npm
apt-get install -y curl
apt-get install -y nginx git git-flow
#apt-get install -y apache2 libapache2-mod-php5 git git-flow
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

npm install -g less

apt-get install -y vim
usermod -s /bin/bash www-data

ln -s /usr/bin/nodejs /usr/local/bin/node

#a2enmod headers

cp /vagrant/deploy/symfony.conf /etc/nginx/sites-enabled/default
cd /var/www/easybill
sudo rm -rf app/cache/* && sudo chmod -R 777 app/cache && php app/console cache:clear
sudo chmod -R 777 app/cache && php app/console cache:clear --env=prod
sudo chmod -R 777 app/cache
php app/console assets:install --symlink web
php app/console assetic:dump
sh bin/rebuild.sh
#cp /vagrant/doc/apache_default_vhost /etc/apache2/sites-available/default
#cp /vagrant/doc/default_site_reconfigured /etc/nginx/sites-available/default
#cp /vagrant/doc/apache_default_vhost_https /etc/apache2/sites-available/default-ssl
/etc/init.d/php5-fpm restart
/etc/init.d/nginx restart
#/etc/init.d/apache2 restart

