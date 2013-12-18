# tardiqueue - Delayed queue for Laravel

A cheap, but effective queue implementation for Laravel. Easy to install like the sync driver, but more performant for the end-user.

This is achieved by registering jobs as shutdown functions, which means that they will only be executed once the application has sent its response to the client

**NOTE:** This driver does not support the `delete()` and `release()` methods for jobs. They can be called, but will not have any effect. Jobs will be deleted automatically after being run, and releasing them will not run them again.

## Installation with Composer

#### Step 1: Install package through Composer

Add this line to the `require` section of your `composer.json`:

    "franzl/tardiqueue": "1.0.x"

Alternately, you can use the Composer command-line tool by running this command:

    composer require franzl/tardiqueue

Next, run `composer install` to actually install the package.

#### Step 2: Register the service provider

In your Laravel application, edit the `app/config/app.php` file and add this
line to the `providers` array:

    'Franzl\Tardiqueue\TardiqueueServiceProvider',

#### Step 3: Configure a delayed queue

In your application, edit the `app/config/queue.php` file and add a new connection using the `delayed` driver, like so:

    'delayed' => array(
        'driver' => 'delayed',
    ),

To actually make this your default queue, set the `default` option to `delayed`, too.

## Usage

Once installed, you can use Laravel's queue feature as you always do. Tardiqueue will then make sure all your queued jobs are run at the end of each request, so that the client can already start rendering while your server is lifting some heavy tasks.
