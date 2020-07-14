<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= HTML::style('css/bootstrap.min.css', [], TRUE) ?>  
    <?= HTML::style('css/main.css', [], TRUE) ?>  
    <title>Restoring access</title>
  </head>
  <body>
    <div class="container">
      <h3>Please reset your password</h3>
      <p class="p-3 mb-2 bg-light small">Restoring token expires at <?= date('H:i:s', $expires) ?></p>
      <div class="row mb-5">
        <div class="col-sm">
          <form method="post">
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
              <small class="form-text text-muted">Должен состоять из букв и цифр. Не менее 8 символов</small>
            </div>
            <div class="form-group">
              <label>Confirm password</label>
              <input type="password" class="form-control" name="password_confirm">
            </div>  
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">  
            <button type="submit" class="btn btn-primary">Reset password</button>
          </form>
          <?php if (!empty($errors)): foreach ($errors as $error): ?>  
          <p class="text-danger"><?= HTML::chars($error) ?></p>  
          <?php endforeach; endif; ?>  
        </div>
        <div class="col-sm"></div>  
      </div>    
    </div>
  </body>
</html>

