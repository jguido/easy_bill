#!/bin/bash
php app/console doctrine:database:drop --force && \
php app/console doctrine:database:create && \
php app/console doctrine:schema:create && \
php app/console doctrine:fixtures:load --no-interaction && \
php app/console cache:clear --env=dev && \
php app/console assets:install && \
php app/console assetic:dump && \
echo "Done!"
