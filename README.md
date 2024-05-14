# Integration Manager Demo
This project showcases [the integration manager package](https://github.com/Brendan-MacKenzie/Integration-Manager) from [Brendan&MacKenzie](https://brendan-mackenzie.com).

## Installation
- Copy the `.env.example` to your own `.env` and setup a mysql database connection.
- Make sure you can fill in the integration keys in your `.env`. And fill them before doing the other steps.
- Run `composer install`
- Run `php artisan migrate`
- Run `php artisan db:seed`

## Take a look
There are some files worth it to take a look at to see how [the integration manager package](https://github.com/Brendan-MacKenzie/Integration-Manager) from [Brendan&MacKenzie](https://brendan-mackenzie.com) is implemented in a Laravel project.

### For example:
#### DatabseSeeder.php
The `database/seeders/DatabaseSeeder.php`. Here you'll see how the example integrations are setup and linked to your 'own code'.

#### integrations.php
The `config/integrations.php` file. This is a published file from the package, but filled with custom data to make the configuration for this project complete.

#### PageController.php
The `app/Http/Controllers/PageController.php` file. Here you'll discover how the Authorization flow and Client Credential flow from the package can be implemented in a Laravel project. 

- The `clientCredentialTest()` function showing the logic for the implementation of the Client Credential flow
- The `authorizationTest()` function showing the logic for the implementation of the Authorization Grant flow. 
- The `authorizationRedirect(Request $request)` function is the logic to process the redirect request from the example Integration with the Authorization Grant flow. You need to implement this route in order to complete this flow. In this function you can see how to do this.

#### web.php
The `routes/web.php` file. Here you'll read the endpoints available in the demo project:
- The `/client-credential` endpoint runs the Client Credential flow.
- The `/authorization` endpoint run the Authorization Grant flow.
- The `/integration/callback` is the default endpoint for the package to complete the Authorization Grant flow and is linked to the `authorizationRedirect()` function in the `PageController.php`.

## Testing
You can test the package implementation by going to the endpoints described above. The project only works with credentials provided for the example integrations.

## Acknowledgements ##
 - [Brendan&MacKenzie](https://www.brendan-mackenzie.com)

 ## Authors

- [@wouterdeberg](https://github.com/wouterdeberg)
- [@Brendan-MacKenzie](https://github.com/Brendan-MacKenzie)

## Issues
- [Report an issue here](https://github.com/Brendan-MacKenzie/Integration-Manager/issues/new)
- [List of open issues](https://github.com/Brendan-MacKenzie/Integration-Manager/issues)