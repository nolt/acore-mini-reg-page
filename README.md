# ACore mini-reg-page

This is a simple and minimalistic registation-only page (no password change, no reset password options available).
This project is dedicated for Azeroth Core (maybe it will work with other cores like CMangos - not tested).

Support : [AzerothCore](http://azerothcore.org)

## Requirements:
Apache2, MariaDB/MySQL, PHP >=7.0

## Installation

 - sudo apt install apache2 php mysql-server php-mbstring php-gd php-gmp php-mysql
 - phpenmod pdo
 - phpenmod pdo_mysql
 - systemctl restart apache2
 - download project or clone to /var/www/html directory
 - go to config/ folder and edit Config.php file
