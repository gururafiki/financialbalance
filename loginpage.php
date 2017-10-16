<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alex March | production </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="login.php" method="post">
              <h1>Вход</h1>
              <div>
                <input type="text" class="form-control" name="login" placeholder="Логин" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Пароль" required="" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Войти</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Впервые на сайте? <i class="fa fa-arrow-right"></i>
                  <a href="#signup" class="to_register"> Сменить пароль </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-bank"></i>Система учета</h1>
                  <p>©2017 All Rights Reserved. Alex March production!</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="signup.php" method="post">
              <h1>Смена пароля</h1>
              <div>
                <input type="text" class="form-control" name="login" placeholder="Логин" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Старый пароль" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="newpass" placeholder="Новый пароль" required="" />
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Сменить пароль</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Уже меняли?
                  <a href="#signin" class="to_register"> Войти </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-bank"></i>Система учета</h1>
                  <p>©2017 All Rights Reserved. Alex March production!</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
