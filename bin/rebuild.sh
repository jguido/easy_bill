#!/bin/bash
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console doctrine:fixtures:load --no-interaction
echo "Done!"
