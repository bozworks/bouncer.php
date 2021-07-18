<?php

/**!
 * Bouncer.php
 * (c) 2021 Boz Works, Onur Boz
 * MIT License
 * https://github.com/bozworks/bouncer.php
 */

namespace Boz;

class Bouncer
{

  //
  // Variables
  //

  /**
   * Version
   *
   * @var string
   */
  public $version = '1.0.0';

  /**
   * Exceptions
   *
   * @var string
   */
  public $exceptions = true;

  /**
   * Current field name
   *
   * @var string
   */
  private $name;

  /**
   * Body
   *
   * @var array
   */
  private $body = array(
    'fieldset'  => array(),
    'valid'     => -1
  );

  /**
   * Settings
   *
   * @var array
   */
  private $settings = array();

  /**
   * Default Settings
   *
   * @var array
   */
  private $defaults = array(
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
      'boolean' => '%label% must be valid boolean value.',
      'integer' => '%label% must be valid integer number.',
      'digits' => '%label% must be valid integer number.',
      'float' => '%label% must be valid floating point number.',
      'numeric' => '%label% must be valid numeric value.',
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
      'email' => '%label% must be valid email address.',
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
        'boolean' => '(Must boolean value)',
        'integer' => '(Must integer number)',
        'digits' => '(Must integer number)',
        'float' => '(Must float number)',
        'numeric' => '(Must numeric value)',
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
        'email' => '(Invalid email address)',
        'ip' => '(Invalid IP address)',
        'url' => '(Invalid internet address)',
        'ccnum' => '(Invalid credit card number)',
        'tcnum' => '(Invalid Turkish Republic identification number)',
      )
    )
  );

  //
  // Public Methods
  //

  /**
   * Constructor.
   *
   * @param string|array|object $data    Optional. An array of key and value pairs, 
   *                                     such as $_POST, $_GET. Default ''.
   * @param array $options               Optional. Settings array to overwrite default settings.
   *                                     Default array().
   */
  public function __construct($data = '', $options = array())
  {
    if (!empty($data)) {
      foreach ($this->parseArgs($data, array()) as $name => $value) {
        if ($this->validName($name)) {
          $this->name($name);
          if ($this->validValue($value)) {
            $this->value($value);
          } else {
            $this->newException();
          }
        } else {
          $this->newException();
        }
      }
    }
    $this->settings = $this->parseArgs($options, $this->defaults);
  }

  /**
   * Sets the current field. If the field is not predefined, it creates an empty one.
   *
   * @param  string $name   Required. Field name.
   * @return object         Bouncer Instance.
   */
  public function name($name)
  {
    if ($this->validName($name)) {
      if (!is_array($this->getField($name))) {
        $this->body['fieldset'][$name] = array(
          'value' => '',
          'valid' => -1
        );
      }
      $this->name = $name;
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Defines the label of the field.
   * - Defines a label to the field that can be used as a variable in error messages.
   *
   * @param  string $label   Required. Field label to add.
   * @return object          Bouncer Instance.
   */
  public function label($label)
  {
    if ($this->validName($label) && is_array($this->getField())) {
      $this->body['fieldset'][$this->name]['label'] = $label;
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Defines the value of the field.
   * - If predefined, it overwrites the value.
   *
   * @param  string|array $value      Required. Field value to set.
   * @return object                   Bouncer Instance.
   */
  public function value($value)
  {
    if (is_array($this->getField()) && $this->validValue($value)) {
      $this->body['fieldset'][$this->name]['value'] = $value;
      $this->body['fieldset'][$this->name]['valid'] = -1;
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field should not be filled.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function empty($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value) {
          return empty($value);
        },
        $message
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be filled in.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function required($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value) {
          if (is_scalar($value)) {
            $value = trim($value);
          }
          return !empty($value);
        },
        $message
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be filled in.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function notempty($message = true)
  {
    return $this->required($message);
  }

  /**
   * Field has to be X characters long.
   *
   * @param  integer|string $length    Required.
   * @param  boolean|string $message   Optional. The error message to show.
   * @return object                    Bouncer Instance.
   */
  public function length($length, $message = true)
  {
    if ($this->getField() && is_numeric($length)) {
      $length = intval($length);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $_length = strlen($value);
          $exclude = (0 === strlen(trim($value)) && false === $args[0]);
          return ($args[1] === $_length || true === $exclude);
        },
        $message,
        array($this->isRequired(), $length)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field has to be greater than or equal to X characters long.
   *
   * @param  integer|string $minlength    Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function minlength($minlength, $message = true)
  {
    if ($this->getField() && is_numeric($minlength)) {
      $minlength = intval($minlength);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen($value);
          $exclude = (0 === strlen(trim($value)) && false === $args[0]);
          return ($args[1] <= $length || true === $exclude);
        },
        $message,
        array($this->isRequired(), $minlength)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field has to be less than or equal to X characters long.
   *
   * @param  integer|string $maxlength    Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function maxlength($maxlength, $message = true)
  {
    if ($this->getField() && is_numeric($maxlength)) {
      $maxlength = intval($maxlength);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen($value);
          $exclude = (0 === strlen(trim($value)) && false === $args[0]);
          return ($args[1] >= $length || true === $exclude);
        },
        $message,
        array($this->isRequired(), $maxlength)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field has to be between minlength and maxlength characters long.
   *
   * @param  integer|string $minlength    Required.
   * @param  integer|string $maxlength    Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function betweenlength($minlength, $maxlength, $message = true)
  {
    if ($this->getField() && is_numeric($minlength) && is_numeric($maxlength)) {
      $minlength = intval($minlength);
      $maxlength = intval($maxlength);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen($value);
          $exclude = (0 === strlen(trim($value)) && false === $args[0]);
          return (($args[1] <= $length && $args[2] >= $length) || true === $exclude);
        },
        $message,
        array($this->isRequired(), $minlength, $maxlength)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a number greater than [or equal to] X.
   *
   * @param  integer|string $min          Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function min($min, $message = true)
  {
    if ($this->getField() && is_numeric($min)) {
      $min = intval($min);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) return true;
          if (!is_numeric($value)) return false;
          return ($args[1] <= intval($value));
        },
        $message,
        array($this->isRequired(), $min)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a number less than [or equal to] X.
   *
   * @param  integer|string $max          Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function max($max, $message = true)
  {
    if ($this->getField() && is_numeric($max)) {
      $max = intval($max);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) return true;
          if (!is_numeric($value)) return false;
          return ($args[1] >= intval($value));
        },
        $message,
        array($this->isRequired(), $max)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a number between X and Y.
   *
   * @param  integer|string $min          Required.
   * @param  integer|string $max          Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function between($min, $max, $message = true)
  {
    if ($this->getField() && is_numeric($min) && is_numeric($max)) {
      $min = intval($min);
      $max = intval($max);
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) return true;
          if (!is_numeric($value)) return false;
          $value = intval($value);
          return ($args[1] <= $value && $args[2] >= $value);
        },
        $message,
        array($this->isRequired(), $min, $max)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid boolean value.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function boolean($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (null !== filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid integer value.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function integer($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (false !== filter_var($value, FILTER_VALIDATE_INT) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid digits.
   * This is just like integer(), except there is no upper limit.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function digits($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (ctype_digit($value) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid float number.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function float($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (false !== filter_var($value, FILTER_VALIDATE_FLOAT) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid numeric value.
   *
   * @param  boolean|string $message     Optional. The error message to show.
   * @return object                      Bouncer Instance.
   */
  public function numeric($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (is_numeric($value) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be an even number.
   *
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function even($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) {
            return true;
          }
          if (0 < $length && !is_numeric($value)) {
            return false;
          }
          return (0 === $value % 2);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be an odd number.
   *
   * @param  boolean|string $message   Optional. The error message to show.
   * @return object                    Bouncer Instance.
   */
  public function odd($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) {
            return true;
          }
          if (0 < $length && !is_numeric($value)) {
            return false;
          }
          return (0 !== $value % 2);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must match a specific value (password comparison etc).
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function matches($string, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return ($args[1] == $value || true === $exclude);
        },
        $message,
        array($this->isRequired(), $string)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must match a specific value (password comparison etc).
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function equal($string, $message = true)
  {
    return $this->matches($string, $message);
  }

  /**
   * Field must differ from a specific value.
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function notmatches($string, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return ($args[1] != $value || true === $exclude);
        },
        $message,
        array($this->isRequired(), $string)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must differ from a specific value.
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function notequal($string, $message = true)
  {
    return $this->notmatches($string, $message);
  }

  /**
   * Field must start with a specific substring.
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function startswith($string, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $string = $args[1];
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return ($string === substr($value, 0, strlen($string)) || true === $exclude);
        },
        $message,
        array($this->isRequired(), $string)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must NOT start with a specific substring.
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function notstartswith($string, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $string = $args[1];
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return ($string !== substr($value, 0, strlen($string)) || true === $exclude);
        },
        $message,
        array($this->isRequired(), $string)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must end with a specific substring.
   *
   * @param  string         $string       Required.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function endswith($string, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $string = $args[1];
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return ($string === substr($value, -strlen($string)) || true === $exclude);
        },
        $message,
        array($this->isRequired(), $string)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must NOT end with a specific substring.
   *
   * @param  string         $string     Required.
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function notendswith($string, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $string = $args[1];
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return ($string !== substr($value, -strlen($string)) || true === $exclude);
        },
        $message,
        array($this->isRequired(), $string)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field has to be one of the allowed ones.
   *
   * @param  string|array   $allowed      Required. Allowed values.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function oneof($allowed, $message = true)
  {
    if ($this->getField()) {
      if (is_array($allowed)) {
        $allowed = implode(',', $allowed);
      }
      if (is_string($allowed)) {
        $this->addRule(
          __FUNCTION__,
          function ($value, $args) {
            $allowed = explode(',', $args[1]);
            $length = strlen(trim($value));
            $exclude = (0 === $length && false === $args[0]);
            return (in_array($value, $allowed, true) || true === $exclude);
          },
          $message,
          array($this->isRequired(), $allowed)
        );
      }
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field has to be not one of the disallowed ones.
   *
   * @param  string|array   $allowed      Required. Allowed values.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function notoneof($disallowed, $message = true)
  {
    if ($this->getField()) {
      if (is_array($disallowed)) {
        $disallowed = implode(',', $disallowed);
      }
      if (is_string($disallowed)) {
        $this->addRule(
          __FUNCTION__,
          function ($value, $args) {
            $disallowed = explode(',', $args[1]);
            $length = strlen(trim($value));
            $exclude = (0 === $length && false === $args[0]);
            return (!in_array($value, $disallowed, true) || true === $exclude);
          },
          $message,
          array($this->isRequired(), $disallowed)
        );
      }
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid email address.
   *
   * @param  boolean        $checkDNS     Optional. Default: "true"
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function email($checkDNS = true, $message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) {
            return true;
          }
          if (!strlen($value)) {
            return false;
          }
          $atIndex = strrpos($value, '@');
          if (!$atIndex && is_bool($atIndex)) {
            return false;
          }
          $domain = substr($value, $atIndex + 1);
          $domainLen = strlen($domain);
          $local = substr($value, 0, $atIndex);
          $localLen = strlen($local);
          if ($localLen < 1 || $localLen > 64) {
            return false;
          }
          if ($domainLen < 1 || $domainLen > 255) {
            return false;
          }
          if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            return false;
          }
          if ($domain[0] == '.' || $domain[$domainLen - 1] == '.') {
            return false;
          }
          if (preg_match('/\\.\\./', $local)) {
            return false;
          }
          if (preg_match('/\\.\\./', $domain)) {
            return false;
          }
          if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            return false;
          }
          if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
          }
          if (true === $args[1] && !(checkdnsrr($domain . '.', "MX") || checkdnsrr($domain . '.', "A"))) {
            return false;
          }
          return true;
        },
        $message,
        array($this->isRequired(), $checkDNS)
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be valid IP address.
   *
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function ip($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (false !== filter_var($value, FILTER_VALIDATE_IP) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be valid internet address.
   *
   * @param  boolean|string $message     Optional. The error message to show.
   * @return object                      Bouncer Instance.
   */
  public function url($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (false !== filter_var($value, FILTER_VALIDATE_URL) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be valid hexadecimal color code.
   *
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function color($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          return (preg_match('/^#([0-9A-Fa-f]{3}){1,2}$/', $value) || true === $exclude);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid credit card number format.
   *
   *  TEST CARDS
   *
   *  34534trdsgfdgdfxgfdg3w653w45  // in valid
   *  378282246310005               // valid
   *  371449635398431               // valid
   *  134449635398431               // in valid
   *  6011111111111117              // valid 
   *  5105105105105100              // valid
   *  asdfasdsadsadsdas             // in valid
   *  30569309025904                // valid
   *  3530111333300000              // valid
   *  12345678912345                // in valid
   *  4070912798591                 // valid
   *  4716699760542841              // valid
   *
   * @see    https://github.com/revive-adserver/revive-adserver/blob/master/lib/Zend/Validate/Ccnum.php
   * @see    https://github.com/bozdev/library/issues/840
   * @param  boolean|string $message     Optional. The error message to show.
   * @return object                      Bouncer Instance.
   */
  public function ccnum($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) {
            return true;
          }
          $value = str_replace(' ', '', $value);
          $length = strlen($value);
          if (!is_numeric($value)) {
            return false;
          }
          if ($length < 13 || $length > 19) {
            return false;
          }
          $sum = 0;
          $weight = 2;
          for ($i = $length - 2; $i >= 0; $i--) {
            $digit = $weight * $value[$i];
            $sum += floor($digit / 10) + $digit % 10;
            $weight = $weight % 2 + 1;
          }
          $mod = (10 - $sum % 10) % 10;
          return ($mod == $value[$length - 1]);
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Field must be a valid Turkish Republic identification number.
   *
   *  TEST NUMBERS
   *
   *  29309796542               // in valid
   *  29309796544               // valid
   *  13449772490               // valid
   *  18451644382               // in valid
   *
   * @see    https://github.com/bozdev/library/issues/821
   * @param  boolean|string $message    Optional. The error message to show.
   * @return object                     Bouncer Instance.
   */
  public function tcnum($message = true)
  {
    if ($this->getField()) {
      $this->addRule(
        __FUNCTION__,
        function ($value, $args) {
          $length = strlen(trim($value));
          $exclude = (0 === $length && false === $args[0]);
          if (true === $exclude) {
            return true;
          }
          $value = str_replace(' ', '', $value);
          if (!is_numeric($value)) {
            return false;
          }
          $length = strlen($value);
          if (11 !== $length) {
            return false;
          }
          if ($value[10] !== substr($value, -1)) {
            return false;
          }
          if (0 === intval($value[0])) {
            return false;
          }
          if (0 !== $value[10] % 2) {
            return false;
          }
          $algorithms[] = ($value[0] +
            $value[1] +
            $value[2] +
            $value[3] +
            $value[4] +
            $value[5] +
            $value[6] +
            $value[7] +
            $value[8] +
            $value[9]) % 10;
          if (intval($value[10]) !== $algorithms[0]) {
            return false;
          }
          $algorithms[] = (
            ($value[0] +
              $value[2] +
              $value[4] +
              $value[6] +
              $value[8]) * 8) % 10;
          if (intval($value[10]) !== $algorithms[1]) {
            return false;
          }
          $algorithms[] = (
            ($value[0] +
              $value[2] +
              $value[4] +
              $value[6] +
              $value[8]) * 7
            +
            ($value[1] +
              $value[3] +
              $value[5] +
              $value[7]) * 9) % 10;
          if (intval($value[9]) !== $algorithms[2]) {
            return false;
          }
          $algorithms[] = (
            ($value[0] +
              $value[2] +
              $value[4] +
              $value[6] +
              $value[8]) * 7
            -
            ($value[1] +
              $value[3] +
              $value[5] +
              $value[7])) % 10;
          if (intval($value[9]) !== $algorithms[3]) {
            return false;
          }
          return true;
        },
        $message,
        array($this->isRequired())
      );
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Add custom callable validation functionality.
   *
   * @param  callable       $callback     Required.
   * @param  mixed          $params       Optional.
   * @param  boolean|string $message      Optional. The error message to show.
   * @return object                       Bouncer Instance.
   */
  public function callback($callback, $params = array(), $message = true)
  {
    if ($this->getField()) {
      if (is_callable($callback)) {
        // If an array is callable, it is a method
        if (is_array($callback)) {
          $function = new \ReflectionMethod($callback[0], $callback[1]);
        } else {
          $function = new \ReflectionFunction($callback);
        }
        if (!empty($function)) {
          // needs a unique name to avoid conflict in the array
          $name = 'callback_' . md5(uniqid(rand(), true));
          $this->addRule(
            $name,
            function ($value, $args) use ($function, $params, $callback) {
              $length = strlen(trim($value));
              $exclude = (0 === $length && false === $args[0]);
              if (true === $exclude) return true;
              $params = (!is_array($params) && !empty($params)) ? array($params) : $params;
              // Creates merge arguments array with validation target as first argument
              $arguments = $this->parseArgs(array($value), $params);
              if (is_array($callback)) {
                // If callback is a method, the object must be the first argument
                return $function->invokeArgs($callback[0], $arguments);
              } else {
                return $function->invokeArgs($arguments);
              }
            },
            $message,
            array($this->isRequired(), $params)
          );
        } else {
          $this->newException();
        }
      } else {
        $this->newException();
      }
    } else {
      $this->newException();
    }
    return $this;
  }

  /**
   * Filter before validating a field's value.
   *
   * @param  mixed   $callback    Required.
   * @return object               Bouncer Instance.
   */
  public function filter($callback)
  {
    $name = $this->name;
    if (is_array($this->getField($name))) {
      if (is_callable($callback)) {
        $this->body['fieldset'][$name]['filters'][] = $callback;
      } else {
        $this->newException();
      }
    } else {
      $this->newException();
    }

    return $this;
  }

  /**
   * Validates existing, preset or all fields.
   *
   * @param  string|boolean $name  Optional. Field name to check. If "true" validates all fields.
   * @return mixed                 Field or Result data. If fails returns "false".
   */
  public function validate($name = '')
  {
    if (true === $name) {
      foreach ($this->prop('fieldset', $this->body, array()) as $_name => $field) {
        $this->validate($_name);
      }
      return $this->getBody();
    } elseif (empty($name)) {
      $name = $this->name;
    }
    $field = $this->getField($name);
    if (is_array($field)) {
      $value = $this->applyFilters($name);
      foreach ($this->prop('rules', $field, array()) as $rule => $true) {
        if (true === $true) {
          $function = $field['functions'][$rule];
          $message = $field['messages'][$rule];
          $args = $field['arguments'][$rule];
          $valid = (empty($args)) ? $function($value) : $function($value, $args);
          if (false === $valid) {
            $this->addError($rule, $message, $args, $name);
          }
        }
      }
    } else {
      $this->newException();
    }
    $field = $this->getField($name);
    $this->body['fieldset'][$name]['valid'] = (false === $this->prop('errors', $field)) ? 1 : 0;
    return $this->getBody();
  }

  /**
   * Returns the values of the specified properties.
   * - Returns all data collected about the field or body, or the specified data.
   *
   * @param  string $property   Optional. Property name.
   * @param  string $name       Optional. Field name.
   * @return mixed              Data.
   */
  public function get($property = '', $name = '')
  {
    if (empty($property)) {
      if (empty($name)) {
        return $this->getBody();
      } elseif (is_array($this->getField($name))) {
        return $this->getField($name);
      }
    } elseif ($this->validName($property)) {
      if (empty($name)) {
        return $this->prop($property, $this->getBody(), null);
      } elseif (is_array($this->getField($name))) {
        return $this->prop($property, $this->getField($name), null);
      }
    }
    return null;
  }

  /**
   * Outputs error messages as HTML.
   *
   * @param  mixed  $options   Optional.
   * @param  string $name      Optional. Field name.
   * @return mixed             Data.
   */
  public function errors($options = array(), $name = '')
  {
    $options = $this->parseArgs($options, array(
      'before' => '',
      'after' => '',
      'item_before' => '',
      'item_after' => '',
      'echo' => ''
    ));
    $result = '';
    if (empty($name)) {
      if (is_array($this->prop('errors', $this->getBody()))) {
        $result .= $options['before'];
        foreach ($this->getBody()->errors as $field => $errors) {
          foreach ($errors as $rule => $error) {
            $result .= $options['item_before'] . $error . $options['item_after'];
          }
        }
        $result .= $options['after'];
      }
    } elseif (is_array($this->prop('errors', $this->getField($name)))) {
      $result .= $options['before'];
      foreach ($this->getField($name)['errors'] as $rule => $error) {
        $result .= $options['item_before'] . $error . $options['item_after'];
      }
      $result .= $options['after'];
    }
    if (!empty($options['echo']) && !empty($result)) {
      echo $result;
    }
    return $result;
  }

  //
  // Private Methods
  //

  /**
   * Return body
   *
   * @return object   body.
   */
  private function getBody()
  {
    $dummy = array();
    foreach ($this->prop('fieldset', $this->prop('body', $this), array()) as $name => $field) {
      $dummy[] = $field['valid'];
    }
    $this->body['valid'] = 1;
    if (in_array(0, $dummy)) {
      $this->body['valid'] = 0;
    }
    if (in_array(-1, $dummy)) {
      $this->body['valid'] = -1;
    }
    return (object) $this->prop('body', $this, array());
  }

  /**
   * Calls the callback functions added to the field's filters.
   *
   * @param  string $name      Required.
   * @return string            Value.
   */
  private function applyFilters($name)
  {
    $field = $this->getField($name);
    if (is_array($field) && isset($field['value'])) {
      $value = &$this->body['fieldset'][$name]['value'];
      foreach ($this->prop('filters', $field, array()) as $filter) {
        $value = $filter($value);
      }
      return $value;
    } else {
      $this->newException();
    }
  }

  /**
   * Add the rule function in the given or current field name.
   *
   * @param  string         $rule       Required. Rule name.
   * @param  closure        $function   Required. Rule function.
   * @param  boolean|string $message    Optional. The error message to show.
   * @param  array          $args       Optional. Field arguments.
   * @param  string         $name       Optional. Field name to check.
   */
  private function addRule($rule, $function, $message = true, $args = array(), $name = '')
  {
    if (empty($name)) $name = $this->name;
    if (
      is_array($this->getField($name)) &&
      $this->validName($rule) &&
      false === $this->prop($rule, $this->prop('rules', $this->getField($name)))
    ) {
      $this->body['fieldset'][$name]['rules'][$rule] = true;
      $this->body['fieldset'][$name]['messages'][$rule] = $this->getMessage($rule, $message, $args, $name);
      $this->body['fieldset'][$name]['arguments'][$rule] = $args;
      if (is_callable($function)) {
        $this->body['fieldset'][$name]['functions'][$rule] = $function;
      }
    } else {
      $this->newException();
    }
  }

  /**
   * Add the rule function in the given or current field name.
   *
   * @param  string         $rule       Required. Rule name.
   * @param  boolean|string $message    Optional. The error message to show.
   * @param  array          $args       Optional. Field arguments.
   * @param  string         $name       Optional. Field name to check.
   */
  private function addError($rule, $message = true, $args = array(), $name = '')
  {
    if (empty($name)) $name = $this->name;
    if (
      is_array($this->getField($name)) &&
      $this->validName($rule) &&
      false !== $this->prop($rule, $this->prop('rules', $this->getField($name)))
    ) {
      $this->body['errors'][$name][$rule] = $this->body['fieldset'][$name]['errors'][$rule] = $this->getMessage($rule, $message, $args, $name);
    } else {
      $this->newException();
    }
  }

  /**
   * Returns the rule message
   *
   * @param  string         $rule       Required. Rule name.
   * @param  boolean|string $message    Optional. The error message to show.
   * @param  array          $args       Optional. Field arguments.
   * @param  string         $name       Optional. Field name to check.
   */
  private function getMessage($rule, $message = true, $args = array(), $name = '')
  {
    if (empty($name)) {
      $name = $this->name;
    }
    if (true === $message) {
      if (!empty($this->settings['messages'][$rule])) {
        $message = $this->settings['messages'][$rule];
      } elseif (false !== strpos($rule, 'callback') && !empty($this->settings['messages']['callback'])) {
        $message = $this->settings['messages']['callback'];
      } elseif (!empty($this->settings['messages']['default'])) {
        $message = $this->settings['messages']['default'];
      } else {
        $message = '';
      }
    }
    $message = str_replace(
      '%argument1%',
      is_array($this->prop(1, $args)) ? implode(',', array_filter($args[1])) : $this->prop(1, $args, ''),
      $message
    );
    $message = str_replace(
      '%argument2%',
      is_array($this->prop(2, $args)) ? implode(',', array_filter($args[2])) : $this->prop(2, $args, ''),
      $message
    );
    $message = str_replace('%label%', $this->prop('label', $this->getField($name), $name), $message);
    $message = str_replace('%value%', $this->prop('value', $this->getField($name), ''), $message);
    $message = str_replace('%rule%', $this->getRuleLabel($rule), $message);
    $message = trim(preg_replace('/\s+|\t+/', ' ', $message));
    return $message;
  }

  /**
   * Return the values of the field
   *
   * @param  string $name   Optional. Field name to check.
   * @return mixed          If not found false.
   */
  private function getField($name = '')
  {
    if (empty($name)) {
      $name = $this->name;
    }
    return $this->validName($name) ? $this->prop($name, $this->body['fieldset']) : false;
  }

  /**
   * Is it a valid field name?
   *
   * @param  string $name   Required. Field name to check.
   * @return boolean        $name, If invalid false.
   */
  private function validName($name = '')
  {
    if (empty($name)) {
      $name = $this->name;
    }
    return !empty($name) && is_string($name) ? $name : false;
  }

  /**
   * Is it a valid field value?
   *
   * @param  string $value  Required. Field value to check.
   * @return boolean        If invalid false.
   */
  private function validValue($value)
  {
    return (is_string($value) || is_array($value)) ? true : false;
  }

  /**
   * Is given or current field required?
   *
   * @param  string  $name   Optional. Field name to check.
   * @return boolean         If "required" true.
   */
  private function isRequired($name = '')
  {
    return true === $this->prop('required', $this->prop('rules', $this->getField($name)));
  }

  /**
   * Return the label of the rule
   *
   * @param  string $rule   Required.
   * @return mixed          If not found ''.
   */
  private function getRuleLabel($rule)
  {
    if (isset($this->settings['rules']['labels'][$rule])) {
      return $this->settings['rules']['labels'][$rule];
    }
    if (isset($this->settings['rules']['labels']['default'])) {
      return $this->settings['rules']['labels']['default'];
    }
    if (isset($rule)) {
      return '(' . $rule . ')';
    }
    return '';
  }

  /**
   * Merges user defined arguments into defaults array.
   *
   * @param  string|array|object $args       Required. Value to merge with $defaults.
   * @param  array               $defaults   Optional. Array that serves as the defaults.
   *                                         Default array().
   * @return array                           Merged user defined values with defaults.
   */
  private function parseArgs($args, $defaults = array())
  {
    if (is_object($args)) {
      $parsed_args = get_object_vars($args);
    } elseif (is_array($args)) {
      $parsed_args = &$args;
    } else {
      parse_str($args, $parsed_args);
    }
    if (is_array($defaults) && $defaults) {
      return array_merge($defaults, $parsed_args);
    }
    return $parsed_args;
  }

  /**
   * Checks if the specified property or key exists in the given array, object or class.
   *
   * @param  mixed                $property    Required. Property or key to check.
   * @param  string|array|object  $args        Required. The array, object or class to search for.
   * @param  mixed                $default     Optional. The value to return when the feature is 
   *                                           not found. Default ''.
   * @return mixed                             If the property exists itself, otherwise the 
   *                                           specified default value is returned. By default it is 
   *                                           false.
   */
  private function prop($property, $args, $default = null)
  {
    if (is_object($args) && property_exists($args, $property)) {
      return $this->prop($property, get_object_vars($args));
    } elseif (is_array($args) && array_key_exists($property, $args)) {
      return $args[$property];
    }
    return (null !== $default) ? $default : false;
  }

  /**
   * Errors exceptions.
   *
   * @param  mixed                $message   Optional. Error message.
   * @param  string|array|object  $code      Optional. Error code.
   */
  private function newException($message = '', $code = 0)
  {
    if ($this->prop('exceptions', $this)) {
      throw new \Exception($message, $code);
    }
  }
}
