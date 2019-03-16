#!/usr/bin/env bash

pushd /vagrant

projectName='scwohlensee'
domainName='scwohlensee.lo'

if [[ ${projectName} == 'placeholder' ]] || [[ ${domainName} == 'placeholder' ]]
then
    echo "projectName must not equal to placeholder. Actual value: ${projectName}"
    echo "domainName must not equal to placeholder. Actual value: ${domainName}"
    exit 1;
fi

echo "Update Packages"
apt remove apache2
apt update

echo "Set host and timezone"
timedatectl set-timezone Europe/Zurich
echo "127.0.0.1 ${domainName}" >> /etc/hosts

echo "Install MySQL and root user"
debconf-set-selections <<< 'mysql-server mysql-server/root_password password password'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password password'
apt install -y mysql-client mysql-server
cp deploy/vagrant/my.cnf /etc/mysql/mysql.cnf
cp deploy/vagrant/mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf

echo "Preparing MySQL Database and application user"
mysql -uroot -ppassword -e"GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'password' WITH GRANT OPTION;"
cp deploy/vagrant/_my_cnf /home/vagrant/.my.cnf
chown vagrant:vagrant /home/vagrant/.my.cnf
chmod 640 /home/vagrant/.my.cnf
service mysql restart

echo "Install Nginx"
apt install -y nginx

echo "Install PHP"
apt install -y php7.2 php7.2-mysql php7.2-xml php7.2-curl php7.2-zip php7.2-gd php7.2-intl php-xdebug php7.2-fpm php7.2-sqlite3 php7.2-bcmath php7.2-sockets gcc make autoconf libc-dev pkg-config php7.2-dev
rm /etc/php/7.2/mods-available/xdebug.ini
cp deploy/vagrant/xdebug.ini.off /etc/php/7.2/mods-available
cp deploy/vagrant/php.ini /etc/php/7.2/fpm/php.ini
cp deploy/vagrant/php.ini /etc/php/7.2/cli/php.ini
cp deploy/vagrant/www.conf /etc/php/7.2/fpm/pool.d/www.conf

#echo "Install phpmyadmin"
#debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
#debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password password'
#debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password password'
#debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password password'
#debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect none'
#apt install -y phpmyadmin

echo "Install git and unzip"
apt install -y git unzip

echo "Install composer"
php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php composer-setup.php --filename=composer --install-dir=/bin
rm composer-setup.php

composer install --prefer-dist --no-progress --no-suggest --no-interaction

echo "Set up Nginx"
cp deploy/vagrant/nginx.conf /etc/nginx/
cp "deploy/vagrant/${projectName}" /etc/nginx/sites-available
rm /etc/nginx/sites-enabled/default
ln -fs "/etc/nginx/sites-available/${projectName}" "/etc/nginx/sites-enabled/${projectName}"
service php7.2-fpm restart
service nginx restart

#echo "Install yarn"
#curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
#echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
#sudo apt-get update
#sudo apt-get install yarn -y

echo "Reset cache"
chmod -R 777 /dev/shm
php bin/console cache:clear
sudo rm -rf "/dev/shm/${projectName}"

echo "Environment variables + shell login"
echo "export SYMFONY_DEPRECATIONS_HELPER=weak" >> /home/vagrant/.profile
echo "export COMPOSER_MEMORY_LIMIT=-1" >> /home/vagrant/.profile
echo "cd /vagrant" >> /home/vagrant/.profile

if [[ ! -d "documents" ]]; then
    mkdir documents
fi

#php bin/console cloudtec:fixtures:load
#php bin/console sylius:install -n