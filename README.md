<h2 align="center">Site for creating support tickets</h2>

## Version 0.2.7

## Installation process
#### from project folder

1. composer install
2. php artisan key:generate
3. php artisan voyager:install
4. php artisan db:seed --class=SupportTicketsBreadSeeder 
5. php artisan db:seed --class=BreadPermissionsSeeder
6. php artisan voyager:admin admin@admin.com --create