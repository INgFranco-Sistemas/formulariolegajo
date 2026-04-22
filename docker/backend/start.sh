#!/bin/sh
set -eu

cd /var/www/html

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache

echo "Esperando a PostgreSQL..."
until php -r '
$host = getenv("DB_HOST") ?: "db";
$port = getenv("DB_PORT") ?: "5432";
$database = getenv("DB_DATABASE") ?: "formulariolegajo";
$username = getenv("DB_USERNAME") ?: "formulariolegajo";
$password = getenv("DB_PASSWORD") ?: "formulariolegajo";

try {
    new PDO("pgsql:host={$host};port={$port};dbname={$database}", $username, $password);
    exit(0);
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
'; do
    sleep 2
done

php artisan config:clear
php artisan migrate --force

if php -r '
require "vendor/autoload.php";
$app = require "bootstrap/app.php";
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
exit(Illuminate\Support\Facades\DB::table("sexes")->count() > 0 ? 1 : 0);
'; then
    php artisan db:seed --force
fi

exec php artisan serve --host=0.0.0.0 --port=8000
