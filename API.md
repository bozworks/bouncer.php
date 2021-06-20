# Bouncer.php API
**Bouncer** is a library that allows you to flexible, quickly and easy to use filter and validate HTML forms.

[← Back to readme](/README.md)

## Table of contents

- [Constructor](#constructor)
- [Options](#options)
- [Methods](#methods)
- [Properties](#properties)
- [Variables](#variables)

## Constructor

```php
new Bouncer( string|array|object $data = '', array $options = array() )
```

### Parameters
- **`$data`** _(string|array|object) (Optional)_ Accepts array, object or query string. The array key is treated as the value pair field and its value. Thus, it is capable of accepting requests such as `$_POST`, `$_GET`.
- **`$options`** _(array) (Optional)_ Accepts arrays to overwrite default variables.

### Return
- **`Bouncer`** Bouncer instance.

### Examples
###### Working with `$_POST`, `$_GET` requests
```php
$variables = array(
  'messages' => array(
    'required' => 'Please fill in the blank fields'
  )
);
$bouncer = new Bouncer($_POST, $variables);
```
###### Working with custom data
```php
$myData = array(
  'name' => 'John',
  'surname' => 'Doe',
  'email' => 'johndoe@example.tld'
);
$bouncer = new Bouncer($myData);
```
###### Working with query string
```php
$bouncer = new Bouncer('name=John&surname=Doe&email=johndoe@example.tld');
```

[↑ Return to top](#bouncerphp-api)

## Options
Bouncer comes with rule labels and error messages by default. You can change these variables in the settings while taking a instance.
>Tip: Use this feature if you just want to change the defaults. At the Bouncer, each rule of each field allows you to add custom error messages.

### Examples
###### Change the "required" error message
```php
$variables = array(
  'messages' => array(
    'required' => 'Please fill in the blank fields'
  )
);
$bouncer = new Bouncer($_POST, $variables);
```

### A complete list of variables

```php
$defaults = array(
  'messages' => array(
    'default' => '%label% contains %rule% rule error.',
    'empty' => '%label% must be left blank.',
    'required' => '%label% must be filled in.',
    'length' => '%label% has to be %argument1% characters long.',
    'minlength' => '%label% must be at least %argument1% characters or longer.',
    'maxlength' => '%label% must be no longer than %argument1% characters.',
    'betweenlength' => '%label% has to be between %argument1% and %argument2% characters long.',
    'min' => '%label% must be greater than or equal to %argument1%.',
    'max' => '%label% must be less than or equal to %argument1%.',
    'between' => '%label% must be a number between %argument1% and %argument2%',
    'email' => '%label% must be valid email address.',
    'boolean' => '%label% must be valid boolean value.',
    'float' => '%label% must be valid floating point numbers.',
    'integer' => '%label% must be valid integer number.',
    'digits' => '%label% must be valid integer number.',
    'even' => '%label% must be an even number.',
    'odd' => '%label% must be an odd number.',
    'matches' => '%label% must be the same as "%argument1%".',
    'notmatches' => '%label% must be different from "%argument1%".',
    'startswith' => '%label% must start with "%argument1%".',
    'notstartswith' => '%label% must not start with "%argument1%".',
    'endswith' => '%label% must be end with "%argument1%".',
    'notendswith' => '%label% must be not end with "%argument1%".',
    'oneof' => '%label% must be one of the allowed "%argument1%".',
    'notoneof' => '%label% must be not one of the disallowed "%argument1%".',
    'ip' => '%label% must be valid IP address.',
    'url' => '%label% must be valid internet address "URL".',
    'ccnum' => '%label% must be valid credit card number.',
    'callback' => '%label% must conform to the required format.',
    'tcnum' => '%label% must be valid Turkish Republic identification number.',
  ),
  'rules' => array(
    'labels' => array(
      'default' => '(Unknown)',
      'empty' => '(Must empty value)',
      'required' => '(Must required)',
      'length' => '(Invalid length)',
      'minlength' => '(Invalid Minimum length)',
      'maxlength' => '(Invalid Maximum length)',
      'betweenlength' => '(Invalid length range)',
      'min' => '(Invalid minimum number)',
      'max' => '(Invalid maximum number)',
      'between' => '(Invalid number range)',
      'email' => '(Invalid email address)',
      'boolean' => '(Must boolean value)',
      'float' => '(Must float number)',
      'integer' => '(Must integer number)',
      'digits' => '(Must integer number)',
      'even' => '(Must even number)',
      'odd' => '(Must odd number)',
      'matches' => '(Must matches with ...)',
      'notmatches' => '(Must not match with ...)',
      'startswith' => '(Must starts with ...)',
      'notstartswith' => '(Must not starts with ...)',
      'endswith' => '(Must ends with ...)',
      'notendswith' => '(Must not ends with ...)',
      'oneof' => '(Must one of allowed)',
      'notoneof' => '(It shouldn\'t be one of disallowed)',
      'ip' => '(Invalid IP address)',
      'url' => '(Invalid internet address)',
      'ccnum' => '(Invalid credit card number)',
      'tcnum' => '(Invalid Turkish Republic identification number)',
    )
  )
);
```

[↑ Return to top](#bouncerphp-api)

## Methods
- [`name()`](#name) - Sets the current field.
- [`label()`](#label) - Defines the label of the field.
- [`value()`](#value) - Defines the value of the field.
- [`validate()`](#validate) - Validates existing, preset or all fields.
- [`get()`](#get) - Returns the values of the specified properties.
- [`errors()`](#errors) - Outputs error messages as HTML.
- [`empty()`](#empty) - Field should not be filled.
- [`required()`](#required) - Field must be filled in.
- [`length()`](#length) - Field has to be X characters long.
- [`minlength()`](#minlength) - Field has to be greater than or equal to X characters long.
- [`maxlength()`](#maxlength) - Field has to be less than or equal to X characters long.
- [`betweenlength()`](#betweenlength) - Field has to be between minlength and maxlength characters long.
- [`min()`](#min) - Field must be a number greater than [or equal to] X.
- [`max()`](#max) - Field must be a number less than [or equal to] X.
- [`between()`](#between) - Field must be a number between X and Y.
- [`boolean()`](#boolean) - Field must be a valid boolean value.
- [`integer()`](#integer) - Field must be a valid integer value.
- [`digits()`](#digits) - Field must be a valid digits.
- [`float()`](#float) - Field must be a valid float number.
- [`numeric()`](#numeric) - Field must be a valid numeric value.
- [`even()`](#even) - Field must be an even number.
- [`odd()`](#odd) - Field must be an odd number.
- [`matches()`](#matches) - Field must match a specific value.
- [`notmatches()`](#notmatches) - Field must differ from a specific value.
- [`startswith()`](#startswith) - Field must start with a specific substring.
- [`notstartswith()`](#notstartswith) - Field must NOT start with a specific substring.
- [`endswith()`](#endswith) - Field must end with a specific substring.
- [`notendswith()`](#notendswith) - Field must NOT end with a specific substring.
- [`oneof()`](#oneof) - Field has to be one of the allowed ones.
- [`notoneof()`](#notoneof) - Field has to be not one of the disallowed ones.
- [`email()`](#email) - Field must be a valid email address.
- [`ip()`](#ip) - Field must be valid IP address.
- [`url()`](#url) - Field must be valid internet address.
- [`color()`](#color) - Field must be valid hexadecimal color code.
- [`ccnum()`](#ccnum) - Field must be a valid credit card number format.
- [`tcnum()`](#tcnum) - Field must be a valid Turkish Republic identification number.
- [`callback()`](#callback) - Add custom callable validation functionality.
- [`filter()`](#filter) - Filter before validating a field's value.

[↑ Return to top](#bouncerphp-api)

### name

```php
name( string $name )
```
Sets the current field.
> If the field is not predefined, it creates an empty one.

#### Parameters
- **`$name`** _(string)_ Field name.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Set the field and determining its value
```php
$bouncer = new Bouncer();
$bouncer
->name('field')
->value('Hello World!');
```
###### Set the field and change its value
```php
$bouncer = new Bouncer(array(
  'field' => 'Yes'
));
$bouncer
->name('field')
->value('No');
```
[↑ Return to top](#bouncerphp-api)

-----

### label

```php
label( string $label )
```
Defines the label of the field.
> Defines a label to the field that can be used as a variable in error messages.

#### Parameters
- **`$label`** _(string)_ The label of the field.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Define the label of the field
```php
$bouncer = new Bouncer(array(
  'field' => 'Yes'
));
$bouncer
->name('field')
->label('Remember Me');
```
[↑ Return to top](#bouncerphp-api)

-----

### value

```php
value( string $value )
```
Defines the value of the field.
> If predefined, it overwrites the value. [(see)](#set-the-field-and-change-its-value)

#### Parameters
- **`$value`** _(string)_ The value of the field.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Change the value of the field
```php
$bouncer = new Bouncer(array(
  'field' => 'Yes'
));
$bouncer
->name('field')
->value('No');
```
[↑ Return to top](#bouncerphp-api)

-----

### validate

```php
validate( boolean|string $name = '' )
```
Validates existing, preset or all fields.

#### Parameters
- **`$name`** _(boolean|string) (Optional)_ Field name. If true, validates all fields. If empty, validates preset field. The default is `''`.

#### Return
- **`mixed`** All body data.
> If it doesn't find any fields, it returns body data without validation.

#### Examples
###### Simple validation
```php
$bouncer = new Bouncer($_POST);
$bouncer->validate(true);
```
###### Validate only one field
```php
$bouncer = new Bouncer(array(
  'author' => 'John',
  'title' => 'Hello World!',
  'content' => 'The quick, brown fox jumps over a lazy dog.',
  'visibility' => ''
));
$bouncer->validate('visibility'); // Only validates the visibility field.
```
[↑ Return to top](#bouncerphp-api)

-----

### get

```php
get( string $property = '', string $name = '' )
```
Returns the values of the specified properties.
> Returns all data collected about the field or body, or the specified data.

#### Parameters
- **`$property`** _(string)_ The property name. [(see)](#properties)
- **`$name`** _(string)_ Field name. If empty, the whole body. The default is `''`.

#### Return
- **`mixed`** Preferred data.

#### Examples
###### Check the validity
```php
$bouncer = new Bouncer(array(
  'title' => 'Hello World!',
  'content' => 'The quick, brown fox jumps over a lazy dog.'
));
$bouncer
->name('title')
->required()
->validate();

var_dump( $bouncer->get('valid', 'title') ); // returns 1
var_dump( $bouncer->get('valid') ); // Returns -1 because the body has fields that have not yet been validated
```
[↑ Return to top](#bouncerphp-api)

-----

### errors

```php
errors( mixed $options = array(), string $name = '' )
```

#### Parameters
- **`$options`** _(mixed)_ Options.

###### Defaults
```php
array(
  'before' => '',
  'after' => '',
  'item_before' => '',
  'item_after' => '',
  'echo' => ''
);
```
- **`$name`** _(string)_ Field name. If empty, the whole errors. The default is `''`.

#### Return
- **`mixed`** HTML output.

#### Examples
###### Print all errors
```php
$bouncer = new Bouncer(array(
  'title' => 'Hello World!',
  'content' => 'The quick, brown fox jumps over a lazy dog.'
));
$bouncer
->name('title')
->required()
->minlength(100)
->name('content')
->required()
->minlength(900)
->validate();

$options = array(
  'before' => '<ol>',
  'after' => '</ol>',
  'error_before' => '<li>',
  'error_after' => '</li>'
);

$bouncer->errors($options, true);
```
[↑ Return to top](#bouncerphp-api)

-----

### empty
```php
empty( boolean|string $message = true )
```
Field should not be filled.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Forcing field to be blank
```php
$bouncer = new Bouncer(array(
  'field' => 'Field value'
));
$bouncer
->name('field')
->empty('Please do not fill in this field.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### required
```php
required( boolean|string $message = true )
```
Field must be filled in.
> It can also be called `notempty()` to make it easier to use.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field is required
```php
$bouncer = new Bouncer(array(
  'field' => ''
));
$bouncer
->name('field')
->required()
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### length
```php
length( integer|string $length, boolean|string $message = true )
```
Field has to be X characters long.

#### Parameters
- **`$length`** _(integer|string)_ Character length.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Limiting a field to a certain number of characters
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello'
));
$bouncer
->name('field')
->length(4)
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### minlength
```php
minlength( integer|string $minlength, boolean|string $message = true )
```
Field has to be greater than or equal to X characters long.

#### Parameters
- **`$minlength`** _(integer|string)_ Minimum character length.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Forcing the field to be above a certain character
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello'
));
$bouncer
->name('field')
->minlength(10)
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### maxlength
```php
maxlength( integer|string $maxlength, boolean|string $message = true )
```
Field has to be less than or equal to X characters long.

#### Parameters
- **`$maxlength`** _(integer|string)_ Maximum character length.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Forcing the field to be below a certain character
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello'
));
$bouncer
->name('field')
->maxlength(3)
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### betweenlength
```php
betweenlength( integer|string $minlength, integer|string $maxlength, boolean|string $message = true )
```
Field has to be between minlength and maxlength characters long.

#### Parameters
- **`$minlength`** _(integer|string)_ Minimum character length.
- **`$maxlength`** _(integer|string)_ Maximum character length.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Limit the field to a specific range of characters
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello'
));
$bouncer
->name('field')
->betweenlength(1, 50, 'The field has an error in the number of characters')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### min
```php
min( integer|string $min, boolean|string $message = true )
```
Field must be a number greater than [or equal to] X.

#### Parameters
- **`$min`** _(integer|string)_ Minimum number.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Force a field to be numerically above a certain value
```php
$bouncer = new Bouncer(array(
  'field' => '99'
));
$bouncer
->name('field')
->min(100, 'Error: This field can be a minimum of %argument1%.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### max
```php
max( integer|string $max, boolean|string $message = true )
```
Field must be a number less than [or equal to] X.

#### Parameters
- **`$max`** _(integer|string)_ Maximum number.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Force a field to be numerically below a certain value
```php
$bouncer = new Bouncer(array(
  'field' => '99'
));
$bouncer
->name('field')
->max(50, 'Error: This field can be a maximum of %argument1%.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### between
```php
between( integer|string $min, boolean|string $max, boolean|string $message = true )
```
Field must be a number between X and Y.

#### Parameters
- **`$min`** _(integer|string)_ Minimum number.
- **`$max`** _(integer|string)_ Maximum number.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Numerically forcing a field to a value within a specified range
```php
$bouncer = new Bouncer(array(
  'field' => '99'
));
$bouncer
->name('field')
->between(50, 60, 'This field should be between %argument1% and %argument2%.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### boolean
```php
boolean( boolean|string $message = true )
```
Field must be a valid boolean value.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid boolean value
```php
$bouncer = new Bouncer(array(
  'field' => 'false'
));
$bouncer
->name('field')
->boolean()
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### integer
```php
integer( boolean|string $message = true )
```
Field must be a valid integer value.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid integer value
```php
$bouncer = new Bouncer(array(
  'field' => '5'
));
$bouncer
->name('field')
->integer('Please enter a valid integer value.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### digits
```php
digits( boolean|string $message = true )
```
Field must be a valid digits.
> This is just like integer(), except there is no upper limit.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid digits
```php
$bouncer = new Bouncer(array(
  'field' => '3e2'
));
$bouncer
->name('field')
->digits('Please enter a valid digits.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### float
```php
float( boolean|string $message = true )
```
Field must be a valid float number.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid float number
```php
$bouncer = new Bouncer(array(
  'field' => '25.5'
));
$bouncer
->name('field')
->float()
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### numeric
```php
numeric( boolean|string $message = true )
```
Field must be a valid numeric value.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid numeric value
```php
$bouncer = new Bouncer(array(
  'field' => '56.6e3'
));
$bouncer
->name('field')
->numeric()
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### even
```php
even( boolean|string $message = true )
```
Field must be an even number.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be an even number
```php
$bouncer = new Bouncer(array(
  'field' => '71'
));
$bouncer
->name('field')
->even()
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### odd
```php
odd( boolean|string $message = true )
```
Field must be an odd number.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be an odd number
```php
$bouncer = new Bouncer(array(
  'field' => '92'
));
$bouncer
->name('field')
->odd()
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### matches
```php
matches( string $string, boolean|string $message = true )
```
Field must match a specific value (password comparison etc).
> It can also be called `equal()` to make it easier to use.

#### Parameters
- **`$string`** _(string)_ String to match.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must match a specific value
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->matches('Hello Bouncer!', 'Field does not match "%argument1%".')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### notmatches
```php
notmatches( string $string, boolean|string $message = true )
```
Field must differ from a specific value.
> It can also be called `notequal()` to make it easier to use.

#### Parameters
- **`$string`** _(string)_ String to match.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must differ from a specific value
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->matches('Hello World!', 'Field should not match "%argument1%".')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### startswith
```php
startswith( string $string, boolean|string $message = true )
```
Field must start with a specific substring.

#### Parameters
- **`$string`** _(string)_ String to match.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must start with a specific substring
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->startswith('Hi')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### notstartswith
```php
notstartswith( string $string, boolean|string $message = true )
```
Field must NOT start with a specific substring.

#### Parameters
- **`$string`** _(string)_ String to match.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must NOT start with a specific substring
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->notstartswith('H')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### endswith
```php
endswith( string $string, boolean|string $message = true )
```
Field must end with a specific substring.

#### Parameters
- **`$string`** _(string)_ String to match.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must end with a specific substring
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->endswith('.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### notendswith
```php
notendswith( string $string, boolean|string $message = true )
```
Field must NOT end with a specific substring.

#### Parameters
- **`$string`** _(string)_ String to match.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must NOT end with a specific substring
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->notendswith('World!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### oneof
```php
oneof( string|array $allowed, boolean|string $message = true )
```
Field has to be one of the allowed ones.

#### Parameters
- **`$allowed`** _(string|array)_ Allowed list. Use an array or separate the words with commas. If you don't want the space to be included in the match, don't add spaces between them.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field has to be one of the allowed ones
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->oneof('Hello Guys!,Hi World!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### notoneof
```php
notoneof( string|array $disallowed, boolean|string $message = true )
```
Field has to be not one of the disallowed ones.

#### Parameters
- **`$disallowed`** _(string|array)_ Disallowed list. Use an array or separate the words with commas. If you don't want the space to be included in the match, don't add spaces between them.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field has to be not one of the disallowed ones
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello World!'
));
$bouncer
->name('field')
->notoneof(
  'Hello Guys!,Hello Friends!,Hello World!', 
  'The field cannot be one of those (%argument1%).'
)->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### email
```php
email( boolean $checkDNS = true, boolean|string $message = true )
```
Field must be a valid email address.

#### Parameters
- **`$checkDNS`** _(boolean)_ If true, it verifies that it is a valid domain name with DNS records. The default is true.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid email address
```php
$bouncer = new Bouncer(array(
  'field' => 'john@example.tld'
));
$bouncer
->name('field')
->email(false, 'Please enter a valid email address.')
->validate();
```
###### Field must be a valid email address and valid DNS records
```php
$bouncer = new Bouncer(array(
  'field' => 'john@example.tld'
));
$bouncer
->name('field')
->email(true, 'Please enter a valid email address.')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### ip
```php
ip( boolean|string $message = true )
```
Field must be valid IP address.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be valid IP address
```php
$bouncer = new Bouncer(array(
  'field' => '120.58.101-449'
));
$bouncer
->name('field')
->ip('[%value%] is not a valid IP address!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### url
```php
url( boolean|string $message = true )
```
Field must be valid internet address.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be valid internet address
```php
$bouncer = new Bouncer(array(
  'field' => 'example.tld'
));
$bouncer
->name('field')
->url('[%value%] is not a valid URL!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### color
```php
color( boolean|string $message = true )
```
Field must be valid hexadecimal color code.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be valid hexadecimal color code
```php
$bouncer = new Bouncer(array(
  'field' => '#ff0000'
));
$bouncer
->name('field')
->url('[%value%] is not a valid color code!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### ccnum
```php
ccnum( boolean|string $message = true )
```
Field must be a valid credit card number format.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid credit card number format
```php
$bouncer = new Bouncer();
$bouncer
->name('field')
->value('12345678912345')
->ccnum('[%value%] is not a valid credit card number!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### tcnum
```php
ccnum( boolean|string $message = true )
```
Field must be a valid Turkish Republic identification number.

#### Parameters
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Field must be a valid Turkish Republic identification number
```php
$bouncer = new Bouncer();
$bouncer
->name('field')
->value('1216608554128')
->label('T.C. identification number')
->tcnum('[%label%] field is not a valid!')
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### callback
```php
callback( callable $callback, mixed $params = array(), boolean|string $message = true )
```
Add custom callable validation functionality.

#### Parameters
- **`$callback`** _(callable)_ The function itself or the name of the function you want to be called.
> If you want to call a method, pass it as a array. Example: `array('class', 'method');`
- **`$params`** _(mixed) (Optional)_ The parameter array to be passed.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Calling an external function
```php
$bouncer = new Bouncer(array(
  'field' => '76e4'
));
$bouncer
->name('field')
->callback('is_numeric', null, 'Field is not numeric.')
->validate();
```
###### Comparing the values of two fields
```php
$bouncer = new Bouncer(array(
  'pass' => '12345',
  'repass' => '01234'
));
$bouncer
->name('repass')
->callback(function( $repass, $pass ) {
  return ( $repass === $pass );
}, array($bouncer->get('value', 'pass')), 'Passwords do not match!')
->validate();
```
###### Creating a custom function
```php
$bouncer = new Bouncer(array(
  'field' => 'Hello Guys!'
));
$bouncer
->name('field')
->callback(function( $value, $arg1 ){
  return ( $arg1 == 'Hello' && false !== strpos($value, 'World') );
}, array('Hello'), 'Since %value% contains the word "Hello", you should also use the word "World" at least once!')
->validate();
```
###### Addicted to another field
```php
$bouncer = new Bouncer(array(
  'product' => 'null',
  'quantity' => '3'
));
$bouncer
->name('piece')
->required()
->integer()
->max(5)
->min(1)
->callback(
  function( $value, $isProductValid ){
    return ( $isProductValid === 1 );
  }, 
  array( $bouncer->get('valid', 'product') ), 
  'Please select a valid product before choosing quantity.'
)
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

### filter
```php
filter( callable $callback )
```
Filter before validating a field's value.

#### Parameters
- **`$callback`** _(callable)_ The function itself or the name of the function you want to be called.
- **`$message`** _(boolean|string) (Optional)_ The error message that will appear. Nothing will appear if `''` is entered. Accepts allowed variables [(See)](#variables). Bool true shows the default message. The default is true.

#### Return
- **`Bouncer`** Bouncer instance.

#### Examples
###### Filtering by external function
```php
$bouncer = new Bouncer(array(
  'field' => '10'
));
$bouncer
->name('field')
->filter('intval')
->integer()
->validate();
```
###### Create new custom function to filter
```php
$bouncer = new Bouncer(array(
  'field' => ' John Doe '
));
$bouncer
->name('field')
->filter(function( $value ){
  return trim( $value );
})
->validate();
```
[↑ Return to top](#bouncerphp-api)

-----

## Properties
Bouncer contains two different data: body data including all field data and data of only a specific field.

### Properties of the whole body
- `fieldset` - Get fields of the whole body,
- `errors` - Get error messages of the whole body ,
- `valid` - Get validity of the whole body. [(see)](#valid-property)

#### `valid` property
|Status|Description|
| ---- | --------- |
| 1 | all fields are valid |
| 0 | at least one field is invalid |
| -1 | at least one field is not validated |

#### Examples
###### Get all data of body
```php
$bouncer->get();
```
###### Get all error messages
```php
$bouncer->get('errors');
```
###### Another way to do this
```php
$bouncer->get()['messages'];
```
###### Get the body validation result
```php
$bouncer->get('valid');
```
[↑ Return to top](#bouncerphp-api)

### Properties of the field
- `value` - Get value of field,
- `errors` - Get error messages of the field,
- `valid` - Get validity of the field, [(see)](#valid-property-1)
- `messages` - Predefined error messages of the field,
- `rules` - Predefined rules of the field,
- `functions` - Predefined functions of the field,
- `arguments` - Predefined arguments of the field.

#### `valid` property
|Status|Description|
| ---- | --------- |
| 1 | the field is valid |
| 0 | the field is invalid |
| -1 | field not yet validated |

#### Examples
###### Get the all data of a specific field
```php
$bouncer->get('', 'fieldname');
```
###### Get the validation result of a specific field
```php
$bouncer->get('valid', 'fieldname');
```
###### Get the rules of a specific field
```php
$bouncer->get('rules', 'fieldname');
```

[↑ Return to top](#bouncerphp-api)

-----

## Variables

Bouncer can filter a number of variables so you can use them in error messages.

- `%value%` - Outputs the value of the field.
- `%label%` - Outputs the label of the field if preset, otherwise the name of the field.
- `%argument1%` - Outputs the first parameter of the related rule.
- `%argument2%` - Outputs the second parameter of the related rule.

#### Examples
###### Mentioning the value of the field in the error message
```php
$bouncer
->name('piece')
->integer('%value% is not a integer.')
->validate();
```
###### Mentioning the arguments of the rule in the error message
```php
$bouncer
->name('piece')
->min(100, 'Error: This field can be a minimum of %argument1%.')
->validate();
```

[← Back to readme](/README.md) / [↑ Return to top](#bouncerphp-api)
