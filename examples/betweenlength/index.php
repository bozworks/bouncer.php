<?php

require '../../src/Bouncer.php';

use Boz\Bouncer as Bouncer;

$bouncer = new Bouncer($_POST);

if (isset($_POST['betweenlength'])) {
  try {
    $bouncer->name('betweenlength')->betweenlength(2, 6, 'Field has to be between <b>%argument1%</b> and <b>%argument2%</b> characters long.')->required('Field must be filled in.')->validate(true);
  } catch (Exception $e) {
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Bouncer betweenlength validation</title>
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
              <h2>Betweenlength validation</h2>
            </div>
            <form method="POST">
              <div class="mb-3">
                <?php
                $betweenlengthErrorClass = 0 === $bouncer->get('valid', 'betweenlength') ? ' is-invalid' : '';
                $betweenlengthErrorMessage = $bouncer->errors(array('before' => '<div class="invalid-feedback d-block">', 'after' => '</div>'), 'betweenlength');
                ?>
                <input class="form-control form-control-lg<?php echo $betweenlengthErrorClass; ?>" type="text" name="betweenlength" placeholder="Enter an any text" />
                <div class="form-text">Enter 2 to 6 characters long</div>
                <?php echo $betweenlengthErrorMessage; ?>
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