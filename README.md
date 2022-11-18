## Install

1. In your terminal run:

```bash
git clone https://github.com/N1V33R4/Lara-Classroom.git
```

Back-end:

2. Set up your database,email and corresponding permissions and roles information in /.env (use the .env.example as an example)

3. In your root folder run:

```bash
composer install
php artisan backpack:filemanager:install

php artisan key:generate
php artisan migrate
php artisan db:seed
```

## Usage

1. Your admin panel is available at /admin
2. After running db:seed you can login with email `admin@admin.admin`, password `admin` as the Super Admin.

## Credits

-   [Forked from Majhoolsoft][link-author]
-   [Backpack for Laravel][link-backpack]

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Yet, for Backpack team it may not be the same for non-commercial use. Please find their corresponding license at [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

[link-author]: https://github.com/majhoolsoft/Ultimate-CMS-for-laboratory-webpage
[link-backpack]: https://backpackforlaravel.com/
