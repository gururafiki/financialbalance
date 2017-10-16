<?php
  require "db.php";
  $username=$_SESSION['name'];
  $userphoto=$_SESSION['photo'];
  $uncomfirmed = R::getAll( "SELECT * FROM `gururafiki_financetotalcontrol`.`transactions` WHERE `status` = 'waiting' AND `confirmator` = '".$username."' ORDER BY `id` ASC, `total` ASC LIMIT 1000;");
  $uncomfirmedcount=R::count('transactions','status = ? AND confirmator = ?',array('waiting',$username))+1;
  if($_SESSION['level']=='SAD38742987aS679as' || $_SESSION['level']=='2138197fcbcsad987s'){
    $username=$_SESSION['name'];
    $users=R::getAll( 'SELECT * FROM `gururafiki_financetotalcontrol`.`users` ORDER BY `id` ASC LIMIT 1000;');
  }
  else{
    header("Location: /loginpage.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Выплата зарплат | <?=$username?> </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <script>
      window.onload = function() {
        $('#customsecondperson').hide();
      };
      function ShowTextSecond(){
        var actualOption=secondpersons.options[secondpersons.selectedIndex].value;
        if(actualOption=='customsecondperson'){
          $('#'+actualOption).show();
        }
        else{
          $('#customsecondperson').hide();
        }
      }
    </script>
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="tablesoutput.php" class="site_title"><i class="fa fa-bank"></i> <span>Система учета</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?=$userphoto?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Добро пожаловать,</span>
                <h2><?=$username?> !</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Меню</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-edit"></i> Формы добавления <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="buyproduct.php">Купить продукт</a></li>
                      <li><a href="saleproduct.php">Продать продукт</a></li>
                      <li><a href="moneytransaction.php">Взять/дать деньги</a></li>
                      <li><a href="givesalary.php">Выплатить зарплату</a></li>
                      <li><a href="adduser.php">Добавить сотрудника</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-table"></i> Таблицы <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="tablesoutput.php">Мои транзакции</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Отчеты <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="aboutproducts.php">Отчет по продукции</a></li>
                      <li><a href="aboutusers.php">Отчет по сотрудникам</a></li>
                      <li><a href="abouttransactions.php">Отчет по транзакциям</a></li>
                      <li><a href="aboutpartners.php">Отчет по партнерам</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-sitemap"></i> Сотрудники<span class="label label-success pull-right">Coming Soon</span><span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Куратор</a>
                        <li><a>Куратор<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Подчиненый</a>
                            </li>
                            <li><a href="#level2_1">Подчиненый</a>
                            </li>
                            <li><a href="#level2_2">Подчиненый</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Куратор</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i>Моя визитка <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Купить/Продать продукт" href="producttransaction.php">
                <i class="fa fa-edit" aria-hidden="true"></i>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Дать/взять деньги" href="addtransaction.php">
                <i class="fa fa-money" aria-hidden="true"></i>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Мои транзакции" href="tablesoutput.php">
                <i class="fa fa-table" aria-hidden="true"></i>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Выход" href="logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=$userphoto?>" alt="">
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="profile.php"> Профиль<span class="label label-success pull-right">Coming Soon</span></a></li>
                    <li>
                      <a href="settings.php">
                        <!-- <span class="badge bg-red pull-right">50%</span> -->
                        <span>Настройки</span>
                        <span class="label label-success pull-right">Coming Soon</span>
                      </a>
                    </li>
                    <li><a href="help.php">Help<span class="label label-success pull-right">Coming Soon</span></a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Выход</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?=$uncomfirmedcount?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php foreach ($uncomfirmed as $transaction):?>
                    <li>
                      <a>
                        <form action="functions.php" method="post">
                          <span>
                            От: <?=$transaction['taker']?><br>
                            Кому: <?=$transaction['giver']?>
                          </span>
                          <span class="message">
                            Продукт : <?=$transaction['name']?><br>
                            На сумму: <?=$transaction['total']?>
                          </span>
                          <span><?=$transaction['date']?></span>
                          <input type="hidden" value="<?=$transaction['id']?>" name="id">
                          <input type="hidden" value="confirm" name="type">
                          <input type="hidden" value="<?=$transaction['confirmator']?>" name="name">
                          <br>
                          <span><button class="btn btn-success" type="submit">Подтвердить</button></span>
                        </form>
                      </a>
                    </li>
                    <?php endforeach;?>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>Заголовок</span>
                          <span class="time">07.08.2012 (15:45:23)</span>
                        </span>
                        <span class="message">
                          Пример текста
                        </span>
                        <span class="label label-success pull-right">Пример</span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>Посмотреть все...</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Работа с транзакциями</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Добавление транзакции <small>Пожалуйста введите необходимые данные</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <!-- Smart Wizard -->
                    <p>Добавление транзакции</p>
                    <form class="form-horizontal form-label-left"  action="functions.php" method="post">
                      <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                          <li>
                            <a href="#step-1">
                              <span class="step_no">1</span>
                              <span class="step_descr">
                                                Шаг 1<br />
                                                <small>Ввод данных</small>
                                            </span>
                            </a>
                          </li>
                          <li>
                            <a href="#step-2">
                              <span class="step_no">2</span>
                              <span class="step_descr">
                                                Шаг 2<br />
                                                <small>Доп. информация</small>
                                            </span>
                            </a>
                          </li>
                          <li>
                            <a href="#step-3">
                              <span class="step_no">3</span>
                              <span class="step_descr">
                                                Шаг 3<br />
                                                <small>Подтверждение</small>
                                            </span>
                            </a>
                          </li>
                        </ul>
                        <div id="step-1">
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="hidden" id="type" name="type" value="salary" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="hidden" id="productname" name="productname" value="Деньги" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="hidden" id="count" name="count" value="1" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="price" class="control-label col-md-3 col-sm-3 col-xs-12">Сумма</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="price" class="form-control col-md-7 col-xs-12" type="text" name="price">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label for="secondpersons" class="control-label col-md-3 col-sm-3 col-xs-12">Кто получает жалование?</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control" name="secondperson" onChange="ShowTextSecond();" id="secondpersons">
                                    <?php foreach ($users as $person) :?>
                                      <option type="radio" name="secondperson" value="<?=$person['name']?>"> <?=$person['name']?></option>
                                    <?php endforeach;?>
                                    <option type="radio" name="secondperson" value="customsecondperson"  >Ввести свой вариант ниже </option>
                                </select>
                              <input class="form-control col-md-7 col-xs-12" type="text" id="customsecondperson" name="customsecondperson">
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                          </div>
                        </div>
                        <div id="step-2">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="info">Приметка(необязательно)
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="info" name="info" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          
                        </div>
                        <div id="step-3">
                          <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <h1 style="color:red;text-align: center;">Проверьте все введенные данные!</h1><br> <h3 style="color:red;text-align: center;">Для этого воспользуйтесь кнопкам "вперед" и "назад" ниже. Когда убедитесь,что все верно - нажмите подтвердить </h3>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            production by <a href="https://alex-march.info">Alex March </a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
  </body>
</html>