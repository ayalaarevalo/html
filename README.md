#StydeNet Html package

This package contains a collection of Laravel PHP classes designed to generate common HTML components, like:

* Menus
* Alert messages
* Form fields
* Collection of radios and checkboxes

This is an extension of the Laravel Collective [HTML package](https://github.com/laravelcollective/html) and will be very useful for you if you are working in a custom CMS, an admin panel or basically any project that needs to generate dynamic HTML.

## How to install

1. You can install this package through Composer. Do this either by running `composer require styde/html ~1.0` or adding `styde/html: ~1.0` to your `composer.json` and running `composer update`.

2. Next, add the new provider to the `providers` array in `config/app.php`

```
  'providers' => [
    // ...
    'Styde\Html\HtmlServiceProvider',
    // ...
  ],
```

3. Add the following middleware to the `$middleware` array in `app/Http/Kernel.php` **BEFORE** the `\App\Http\Middleware\EncryptCookies`: 

```
protected $middleware = [
    //...
    \Styde\Html\Alert\Middleware::class
    //...
];
```

This middleware is needed to persist the alert messages after each request is completed, and this is it.

Please notice that the following global aliases will be automatically available (you don't need to add them):

```
    'Alert'	=> Styde\Html\Facades\Alert,
    'Field'	=> Styde\Html\Facades\Field,
    'Menu'	=> Styde\Html\Facades\Menu,
```

In case you plan to use the Access Handler as a standalone class, you need to add this alias:

```
  'aliases' => [
    // ...
    'Access' => Styde\Html\Facades\Access,
    // ...
  ],
```

Optionally, you may also run `php artisan vendor:publish --provider='Styde\Html\HtmlServiceProvider'` to publish the configuration file and explore at own will.

## Usage

Since this package is largely using [LaravelCollective/Html](https://github.com/laravelcollective/html), following their documentation is sufficient for the forms and fields base functionality.

## Sandbox

This package is well documented and unit tested; however, there is also another repository that includes integration tests and several routes, so you can clone that repository to watch this component in action in your browser or take a look and run the integration tests (is another way to learn about this component, besides reading this documentation).

[Go to the sandbox repository](https://github.com/StydeNet/html-integration-tests)

## Configuration

This package was created with configuration in mind, if you haven't used this component before, you can just simply run:

`php artisan vendor:publish --provider='Styde\Html\HtmlServiceProvider'`

to publish all the configuration options to: `config/html.php`, then you can just explore them and read the comments.
  
Since the default configuration will be merged with the custom configuration, you don't need to publish the entire configuration, you can just set the values you need to override.  

Read this documentation to learn more about different configuration options this package provides.

## Form Field builder

This component will allow you to render the full dynamic markup you need for a form field with only one line of code.

If you have used the Laravel Collective HTML component before, you already know how to use the basics of this component; simply replace the alias “Form” for “Field”, for example, replace:

`{!! Form::text(‘name’, ‘value’, $attributes) !!}`

For this:

`{!! Field::text(‘name’, ‘value’, $attributes) !!}`

[Learn more about the field builder](docs/field-builder.md)

## Forms

This package adds the following functionality to the Laravel Collective's Form Builder:

#### novalidate

Deactivate the HTML5 validation, ideal for local or development environments

```
//config/html.php
return [
    'novalidate' => true
];
```

#### radios

Generate a collection of radios:

`{!! i.e. Form::radios('status', ['a' => 'Active', 'i' => 'Inactive']) !!}`

#### checkboxes

Generate a collection of checkboxes

```
$options = [
    'php' => 'PHP',
    'js' => 'JS'
];
$checked = ['php'];
```

`{!! Form::checkboxes('tags', $options, $checked) !!}`

[Learn more about the form builder](docs/form-builder.md)

## Alert messages

This component will allow you to generate complex alert messages.

```
        Alert::info('Your account is about to expire')
            ->details('Renew now to learn about:')
            ->items(['Laravel', 'PHP, 'And more!'])
            ->button('Renew now!', url('renew'), 'primary');
```

`{!! Alert::render() !!}`

[Learn more about the alert component](docs/alert-messages.md)

## Menu generator

Menus are not static elements, you either need to mark the active section, translate items, generate dynamic URLs or show/hide options for certain users.

So instead of adding a lot of HTML and Blade boilerplate code, you can use this component to generate dynamic menus styled for your current CSS framework.

To generate a menu simply add the following code in your layout's template:

`{!! Menu::make('items.here') !!}`

[Learn more about the menu generator](docs/menu-generator.md)

## HTML builder

This package extends the functionality of the Laravel Collective's HTML Builder.

There's only one extra method _for now_, but it's very useful!

####Generate CSS classes:

`{!! Html::classes(['home' => true, 'main', 'dont-use-this' => false]) !!}`

Returns: ` class="home main"`.

[Learn more about the html builder](docs/html-builder.md)

### Helpers

In addition of using the facade methods `Alert::message` and `Menu::make`, you can use:

`alert('this is the message', 'type-of-message')`

`menu($items, $classes)`

## Access handler

Sometimes you want to show or hide certain menu items, form fields, etc. for certain users, with this component you can do it without the need of conditionals or a lot of boiler plate code, just pass one of the following options as a field attribute or menu item value.

1. callback: should return true if access is granted, false otherwise.
2. logged: true: requires authenticated user, false: requires guest user.
3. roles: true if the user has any of the required roles.

i.e.: 

`{!! Field::select('user_id', null, ['roles' => 'admin'])`

[Learn more about the access handler](docs/access-handler.md)

## Themes

There are a lot of CSS (in fact, there's a lot of all kind of) frameworks out there, this package was created with that in mind, and even though only Twitter Bootstrap is included out of the box, we plan to add more packages in the future (we also invite you to collaborate) also, it very easy to create your own themes, publish and customize all the templates if you need to.

To change and / or customize the theme, simply run: 

`php artisan vendor:publish`

Then go to `config/html.php` and change the theme value:

```
//config/html.php
return [
    'theme' => 'your-theme-here'
];
```

You can edit and/or create new templates in `resources/views/themes/` 

[Learn more about the themes](docs/themes.md)

## Internationalization

You can configure whether you want this package to attempt to translate texts or not. For example, if your project only needs to implement one language, you can deactivate translations in the configuration:

```
//config/html.php
return [
  //...
  'translate_texts' => false
  //...
];
```

But if your project needs to implement more than one language or you want to organize all the texts in one place instead of hardcoding them in the controllers, views, etc. set `'translate_texts'` to `true`.

[Learn more about the internationalization](docs/internationalization.md)

## More documentation

You can find a lot of docblock comments if you dig into the source course, as well as unit tests in the spec/ directory, you can also clone the [integration tests repository](https://github.com/StydeNet/html-integration-tests).
