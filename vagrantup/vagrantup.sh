#!/bin/bash

set -x
set -e

echo "Installing software ..."

# Update packages list
apt-get update

# Adding PPA to install php7
apt-get install -y python-software-properties software-properties-common
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

# Adding PPA to install git
add-apt-repository ppa:git-core/ppa

# Adding PPA to install wkhtmltopdf
add-apt-repository ppa:ecometrica/servers

# Updating repo index after adding PPA
apt-get update

# Preparing answers for automatic install
DB_PASS=root
debconf-set-selections <<< "mysql-server mysql-server/root_password password ${DB_PASS}"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password ${DB_PASS}"

# Accept github.com ssh-key
echo -e "Host github.com\n\tStrictHostKeyChecking no\n" >> ~/.ssh/config

# Install packages
apt-get install git -y
apt-get install curl -y
apt-get install mc -y
apt-get install apache2 -y
apt-get install mysql-server -y
apt-get install php7.0 -y
apt-get install php7.0-mysql -y
apt-get install libapache2-mod-php7.0 -y
apt-get install php7.0-curl -y
apt-get install php7.0-json -y
apt-get install php7.0-xml -y
apt-get install php7.0-zip -y

# Install composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install phpunit
wget -q https://phar.phpunit.de/phpunit-6.1.phar
chmod +x phpunit-6.1.phar
mv phpunit-6.1.phar /usr/local/bin/phpunit

# Make the apache load under our user account.
sed -ri 's/^(export APACHE_RUN_USER=)(.*)$/\1vagrant/' /etc/apache2/envvars
sed -ri 's/^(export APACHE_RUN_GROUP=)(.*)$/\1vagrant/' /etc/apache2/envvars

# Enabling apache modules
cd /etc/apache2/mods-enabled/
ln -sf ../mods-available/rewrite.load rewrite.load
ln -sf ../mods-available/headers.load headers.load

# Set apache global ServerName
cp -f /vagrant/vagrantup/etc/apache2/conf-available/globalname.conf /etc/apache2/conf-enabled/

# Set virtual hosts
rm -rf /etc/apache2/sites-enabled/*
cp -f /vagrant/vagrantup/etc/apache2/sites-available/vhosts.conf /etc/apache2/sites-enabled/

# Restart apache
/etc/init.d/apache2 restart

# Install dependencies
cd /vagrant
cp -a phpunit.xml.dist phpunit.xml

# Update crontab file
cp -f /vagrant/vagrantup/etc/crontab /etc/crontab

echo "cd /vagrant" >> /home/vagrant/.bashrc

echo "Software installed..."

#Install application
sh bin/install.sh