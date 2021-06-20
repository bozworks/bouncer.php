# Bouncer.php

**Bouncer** is a library that allows you to flexible, quickly and easy to use filter and validate HTML forms.

[Examples](../../tree/master/examples) · [Open issue](../../issues/new/choose) · [Report bug](../../issues/new?assignees=&labels=&template=bug_report.md&title=)

## Table of contents

- [Features](#features)
- [Quick start](#quick-start)
- [API](/API.md)
- [License](#license)
- [Changelog](/CHANGELOG.md)
- [Release notes](#release-notes)
- [Future release plans](#future-release-plans)
- [Known questions](#known-questions)
- [Credits](#credits)

## Features
- 👍 It is very easy to use and does not require any dependency.
- 🎭 The entire form can be validate at the same time or optionally particular fields can also be validate.
- 🎯 You do not need to check the validity of each field separately. Bouncer keeps track of the validity of the entire form for you.
- 🛠️ It has predefined error messages for each validation method and these messages can be changed from the options.
- ✔️ You can create custom validation and filter methods for each field.
- 📋 You can define custom error messages for each field.
- 📌 Supports error messages (value, parameters, field label if predefined and rule title) variables.
- 📐 Includes more than 30 different built-in methods for validation and filtering.
- ♻️ It has the ability to automatically add form data submitted with `$_POST` and `$_GET` requests. Thus, you do not need to define the form fields one by one.
- 💲 It is completely free to use and open source.

[&#8593; Return to top](#bouncerphp)

## Quick start
Bouncer can be used either with or without Composer.
### With Composer
The preferred way to use Bouncer is with Composer. Execute the following command to install this package as a dependency in your project:

```shell
composer require bozworks/bouncer.php
```
```php
<?php
  use Boz\Bouncer as Bouncer;
  //Load Composer's autoloader
  require 'vendor/autoload.php';
  new Bouncer();
```
### Without Composer

Bouncer does not have any dependencies. Therefore, you can [download](../../archive/refs/heads/master.zip) and include it directly in your file and start using it:

```php
<?php
  require 'class.bouncer.php';
  use Boz\Bouncer as Bouncer;
  new Bouncer();
```

### Simple example

In the example below, let's basically verify a user's session information with Bouncer.

```php
<?php
  require 'class.bouncer.php';
  use Boz\Bouncer as Bouncer;
  
  $bouncer = new Bouncer(array(
    'useremail' => 'john@example.tld',
    'password' => '12345',
    'expiry' => '3 day'
  ));
  
  $bouncer
  ->name('useremail')
  ->required()
  ->email()
  ->name('password')
  ->required()
  ->callback(function($password){ return ('12345' === $password); })
  ->name('expiry')
  ->required()
  ->minlength(5)
  ->endswith('day')
  ->validate(true);
  
  if($bouncer->get('valid') === 1) {
    openSession(
      $bouncer->get('value', 'useremail'),
      $bouncer->get('value', 'expiry')
    );
    echo '<div role="alert" class="msg success">Successfully Logged In</div>';
  } else {
    foreach($bouncer->get('errors') as $field => $errors) {
      foreach ($errors as $rule => $error) {
        echo '<div role="alert" class="msg error">' . $error . '</div>';
      }
    }
  }
```

You can find a complete guide example in the [examples](/examples/) folder.

[&#8593; Return to top](#bouncerphp)

## License
Bouncer's code is released under the [MIT License](/LICENSE), the art and docs are released under [Creative Commons](https://creativecommons.org/licenses/by/4.0/). `(MIT AND CC-BY-4.0)`

[&#8593; Return to top](#bouncerphp)

## Release notes

- Automatically print the error messages based on the field.
- Added some improvements and examples.

See the [change log](/CHANGELOG.md).

[&#8593; Return to top](#bouncerphp)

## Future release plans

- Multiple rule support.
- New methods "contains" and "notcontains".

See the [change log](/CHANGELOG.md).

[&#8593; Return to top](#bouncerphp)

## Known questions

#### Can more than one rule be defined?
- Yes Bouncer is capable of handling multiple rules.
#### Can more than one custom callbacks be defined?
- Yes Bouncer is capable of handling multiple callbacks.
#### Can it be defined more than one from the same validation rule?
- No, for now it can only be defined once from the same rule. Bouncer is planned to have this ability in the future.

[&#8593; Return to top](#bouncerphp)

## Credits
> This repository is inspired by bouncer.js

Get the JavaScript version developed by @cferdinandi. [Bouncer.js](https://github.com/cferdinandi/bouncer)

[&#8593; Return to top](#bouncerphp)
