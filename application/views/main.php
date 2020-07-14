<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= HTML::style('css/bootstrap.min.css', [], TRUE) ?>  
    <?= HTML::style('css/main.css', [], TRUE) ?>  
    <title>Test Kohana app for New Disk</title>
  </head>
  <body>
    <div class="container">  
      <h3>Метод /ajax/<b>content</b></h3>
      <p class="p-3 mb-2 bg-light small">Получает список новостей с главной страницы http://meduza.io. 
        Выбирает случайную из новостей и возвращает заголовок, анонс и ссылку на изображение (если есть).
        При этом сохраняется упоминание этой новости для текущего клиента, чтобы при следующем запросе
        не возвращать те новости, что уже отдавались этому клиенту. Если на главной странице не осталось
        новостей, которых клиент еще не получал, очищаем список, хранящийся для этого клиента.
      </p>
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'content'], TRUE) ?>">
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">
            <button type="submit" class="btn btn-primary">Получить случайную новость</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>registration</b></h3>
      <p class="p-3 mb-2 bg-light small">Регистрация клиента с проверкой уникальности логина/email и надежности пароля.</p>
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'registration'], TRUE) ?>">
            <div class="form-group">
              <label>Логин</label>
              <input type="input" class="form-control" name="username">
            </div>  
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
              <small class="form-text text-muted">Должен состоять из букв и цифр. Не менее 8 символов</small>
            </div>
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">  
            <button type="submit" class="btn btn-primary">Регистрация</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>login</b></h3>
      <p class="p-3 mb-2 bg-light small">Авторизация по логину и паролю.</p>
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'login'], TRUE) ?>">
            <div class="form-group">
              <label>Логин/Email</label>
              <input type="input" class="form-control" name="username">
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="password">
            </div>
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">    
            <button type="submit" class="btn btn-primary">Авторизация</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>logout</b></h3>
      <p class="p-3 mb-2 bg-light small">Выполняет разлогинивание.</p>
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'logout'], TRUE) ?>">
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">      
            <button type="submit" class="btn btn-primary">Разлогиниться</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>forgot</b></h3>
      <p class="p-3 mb-2 bg-light small">Восстановление забытого пароля с верификацией через почту.</p>
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'forgot'], TRUE) ?>">
            <div class="form-group">
              <label>Email address</label>
              <input type="email" class="form-control" name="email">
              <small class="form-text text-muted">Для восстановления доступа укажите свой регистрационный email-адрес</small>
            </div>
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">     
            <button type="submit" class="btn btn-primary">Восстановить доступ</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>exchangerate</b></h3>
      <p class="p-3 mb-2 bg-light small">Получает курс доллара/евро/фунта стерлингов (нужная валюта post-переменной) к рублю..</p>
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'exchangerate'], TRUE) ?>">
            <div class="form-group">
              <label for="exampleInputEmail1">Код валюты</label>
              <input type="input" class="form-control" name="currency" value="USD">
              <small id="emailHelp" class="form-text text-muted">Currency code, eg. USD, EUR, UAH, etc.</small>
            </div>
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">     
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>word</b></h3>
      <p class="p-3 mb-2 bg-light small">Получаем post-переменную word и сохраняем значение в БД.</p>
    
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'word'], TRUE) ?>">
            <div class="form-group">
              <label>Word</label>
              <input type="input" class="form-control" name="name">
            </div>
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">     
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>words</b></h3>
      <p class="p-3 mb-2 bg-light small">Постраничный вывод всех записей, полученных методом выше.</p>
    
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'words'], TRUE) ?>">
            <div class="form-group">
              <label>Page number</label>
              <input type="number" class="form-control" min="1" step="1" name="page" value="1">             
            </div>
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">   
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
      
    
      <h3>Метод /ajax/<b>wordstat</b></h3>
      <p class="p-3 mb-2 bg-light small">Вывод самых часто встречающихся слов в words в порядку уменьшения популярности.</p>
      
      <div class="row mb-5">
        <div class="col-sm">
          <form action="<?= Route::url('ajax', ['action' => 'wordstat'], TRUE) ?>">
            <input type="hidden" name="_csrf" value="<?= Security::token() ?>">   
            <button type="submit" class="btn btn-primary">Получить</button>
          </form>
        </div>
        <div class="col-sm">
          <p>Результат:</p>
          <p class="result text-monospace"></p>
        </div>    
      </div>
    
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?= HTML::script('js/jquery.min.js', [], TRUE) ?>  
    <?= HTML::script('js/popper.min.js', [], TRUE) ?>  
    <?= HTML::script('js/bootstrap.min.js', [], TRUE) ?>  
    <?= HTML::script('js/main.js', [], TRUE) ?>  
  </body>
</html>

