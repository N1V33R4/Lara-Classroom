## Demo

To check out its admin panel use:

Email: demo@majhoolsoft.com

Password: demo

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

<!-- Front-end:

4. Set up your desired (translation) locale by uncommenting corresponding values in config/backpack/crud.php

5. Set up your translation data and sitekey for Google recaptcha in resources/translations.json

6. In your root folder run:

```bash
npm install
npx mix --production
``` -->

## Usage

1. Your admin panel is available at /admin
2. After running db:seed you can login with email `admin@admin.admin`, password `admin` as the Super Admin.
<!-- 
Note:

1. By default, registration is open only in your local environment. Check out `config/backpack/base.php` to change this and other preferences.

2. Depending on your configuration you may need to define a site within NGINX or Apache; Your URL domain may change from localhost to what you have defined. -->

## Credits

-   [Forked from Majhoolsoft][link-author]
-   [Backpack for Laravel][link-backpack]

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Yet, for Backpack team it may not be the same for non-commercial use. Please find their corresponding license at [backpackforlaravel.com](https://backpackforlaravel.com/#pricing) for more information.

[link-author]: https://github.com/majhoolsoft/Ultimate-CMS-for-laboratory-webpage
[link-backpack]: https://backpackforlaravel.com/
