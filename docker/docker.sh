php bin/console d:m:m --no-interaction
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=dev
php bin/console cache:warmup --env=prod

exec apache2-foreground
# Jouer les migrations ici