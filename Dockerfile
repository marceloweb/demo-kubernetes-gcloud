FROM marceloweb/twitter:1.0

USER root

RUN wget https://phar.phpunit.de/phpunit-6.5.phar \
    chmod +x phpunit-6.5.phar \
    mv phpunit-6.5.phar /usr/local/bin/phpunit \
    phpunit --version

COPY src /var/www/html/app

EXPOSE 80
