<h2 align="center">Site for creating support tickets</h2>

## Version 1.1.5

## Installation process
#### from project folder

sudo chown -R www-data:www-data /var/www/html/hat_almasu
sudo chmod -R 775 /var/www/html/hat_almasu
sudo chmod -R 775 /var/www/html/hat_almasu/storage
sudo chmod -R 775 /var/www/html/hat_almasu/bootstrap/cache

1. composer install
2. php artisan key:generate
3. php artisan voyager:install
4. php artisan db:seed --class=SupportTicketsBreadSeeder 
5. php artisan db:seed --class=BreadPermissionsSeeder
6. php artisan voyager:admin admin@admin.com --create