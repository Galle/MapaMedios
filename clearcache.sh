# Removemos la carpetas temporales
rm -r app/cache
rm -r app/logs
rm -r app/spool
rm -r app/Resources/public

# Creamos nuevamente las carpetas
mkdir app/cache
mkdir app/logs
mkdir app/spool
mkdir app/Resources/public
mkdir app/Resources/public/less

# Limpiamos el cache
php app/console cache:clear --env=dev

# Actualizamos la base de datos
php app/console doctrine:schema:update --force

# Creamos los permisos
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs app/spool web/css/ web/uploads web/media web/css/colors* app/Resources/public/less/ /tmp/Google_Client
setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs app/spool web/css/ web/uploads web/media web/css/colors* app/Resources/public/less/ /tmp/Google_Client
