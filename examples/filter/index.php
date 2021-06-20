<?php

require '../../src/Bouncer.php';

function console_log($data, $context = 'Debug in Console') {

  // Buffering to solve problems frameworks, like header() in this and not a solid return.
ob_start();

$output  = 'console.info(\'' . $context . ':\');';
$output .= 'console.log(' . json_encode($data) . ');';
$output  = sprintf('<script>%s</script>', $output);

echo $output;
}

use Boz\Bouncer as Bouncer;

$bouncer = new Bouncer($_POST);

if (isset($_POST['filter'])) {
  try {
    $bouncer->name('filter')->filter(function($value){
      return $value === 'Hello' ? 'Hi' : $value;
    })->equal('Hi', "Please enter \"Hi\" or \"Hello\" in the field!")->required()->validate(true);
  } catch (Exception $e) {
    echo ($e);
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Bouncer validation filter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body class="bg-light">
  <main>
    <div class="container py-5">
      <a class="d-block text-light text-decoration-none text-center bg-success rounded p-5 mb-5" href="https://github.com/bozdev-workspace/bouncer.php/">
        <h1 class="display-1 fw-normal">Bouncer</h1>
        <div class="lh-1">Go to Github project page</div>
      </a>
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8">
          <div class="bg-white p-5 rounded border">
            <div class="text-center mb-4">
              <h2>Validation filter</h2>
            </div>
            <form method="POST">
              <div class="mb-3">
                <?php
                $filterErrorClass = 0 === $bouncer->get('valid', 'filter') ? ' is-invalid' : '';
                $filterErrorMessage = $bouncer->errors(array('before' => '<div class="invalid-feedback d-block">', 'after' => '</div>'), 'filter');
                ?>
                <input class="form-control form-control-lg<?php echo $filterErrorClass; ?>" type="text" name="filter" placeholder="Enter 'Hello'" />
                <?php echo $filterErrorMessage; ?>
                <div class="form-text">If you enter <b>Hello</b> it will be filtered for the <b>Hi</b>.</div>
              </div>
              <div class="d-grid">
                <button class="btn btn-lg d-block btn-success" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>