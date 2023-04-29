Rental Management Tool for Real Estate Agency (school project)

This tool allows real estate agencies to manage their rental properties (apartments), tenants, rentals, and payments in one place. Here are the features included:

Features

Add / edit / delete an apartment
Add / edit / delete a rental
Add / edit / delete an inventory of fixtures
Add / edit / delete a tenant
Add / edit / delete tenant payments for rent
Assign a rental to an apartment
Assign a tenant, inventory of fixtures, and payment to a rental
Generate rent receipts for a specific period. This feature is only available if the tenant is up-to-date with rental payments during the period
Send rent receipts to tenants via email
Add a photo (ID of the tenant's guarantor)
Calculate a balance of rent, charges, and deposit payments when a tenant leaves the property

Installation

Clone the repository from GitHub
Install dependencies by running composer install
Create a new database
Run migrations by running php bin/console doctrine:migrations:migrate
Start the server by running symfony server:start

Usage

Navigate to the web app in your browser
Login with your credentials once registered
Use the navigation menu to access different features
Add / edit / delete apartments, rentals, inventory of fixtures, tenants, and payments as needed
Generate rent receipts and send them to tenants via email
Calculate the balance of rent, charges, and deposit payments when a tenant leaves the apartment

Dependencies

PHP (>=8.0.2)
ext-ctype
ext-iconv
doctrine/annotations (^2.0)
doctrine/doctrine-bundle (^2.8)
doctrine/doctrine-migrations-bundle (^3.2)
doctrine/orm (^2.14)
phpdocumentor/reflection-docblock (^5.3)
phpstan/phpdoc-parser (^1.16)
sensio/framework-extra-bundle (^6.2)
symfony/asset (6.0._)
symfony/console (6.0._)
symfony/doctrine-messenger (6.0._)
symfony/dotenv (6.0._)
symfony/expression-language (6.0._)
symfony/flex (^2)
symfony/form (6.0._)
symfony/framework-bundle (6.0._)
symfony/http-client (6.0._)
symfony/intl (6.0._)
symfony/mailer (6.0._)
symfony/mime (6.0._)
symfony/monolog-bundle (^3.0)
symfony/notifier (6.0._)
symfony/process (6.0._)
symfony/property-access (6.0._)
symfony/property-info (6.0._)
symfony/runtime (6.0._)
symfony/security-bundle (6.0._)
symfony/serializer (6.0._)
symfony/string (6.0._)
symfony/translation (6.0._)
symfony/twig-bundle (6.0._)
symfony/validator (6.0._)
symfony/web-link (6.0._)
symfony/yaml (6.0._)
twig/extra-bundle (^2.12|^3.0)
twig/twig (^2.12|^3.0)
vich/uploader-bundle (^1.23)

Development Dependencies

doctrine/doctrine-fixtures-bundle (^3.4)
phpunit/phpunit (^9.5)
symfony/browser-kit (6.0._)
symfony/css-selector (6.0._)
symfony/debug-bundle (6.0._)
symfony/maker-bundle (^1.0)
symfony/phpunit-bridge (^6.2)
symfony/stopwatch (6.0._)
symfony/web-profiler-bundle (6.0.\*)
