<?php
  require "db.php";
  $username=$_SESSION['name'];
  $userphoto=$_SESSION['photo'];
  $uncomfirmed = R::getAll( "SELECT * FROM `gururafiki_financetotalcontrol`.`transactions` WHERE `status` = 'waiting' AND `confirmator` = '".$username."' ORDER BY `id` ASC, `total` ASC LIMIT 1000;");
  $uncomfirmedcount=R::count('transactions','status = ? AND confirmator = ?',array('waiting',$username))+1;
  if($_SESSION['level']=='SAD38742987aS679as'){
    $username=$_SESSION['name'];
    $users=R::getAll( 'SELECT * FROM `gururafiki_financetotalcontrol`.`users` ORDER BY `id` ASC LIMIT 1000;');
    $arrUsers = [];
    foreach ($users as $user) {
        if($user['name']!='Александр Марченко'){
           $balance[$user['name']] = $user['balance'];
           $totalprice[$user['name']] = $user['totalprice'];
           $lastsalary[$user['name']] = $user['lastsalary'];
           $lastpay[$user['name']] = $user['lastpay'];
           $count_transactions[$user['name']] = R::count($user['latin'],'type != ?',array('cancel')) - R::count($user['latin'],'type = ?',array('cancel'));
           $arrUsers[$user['name']] = R::getAll( "SELECT * FROM `gururafiki_financetotalcontrol`.`".$user['latin']."` ORDER BY `id` ASC LIMIT 1000;");
        }
    }
  }
  elseif( $_SESSION['level']=='2138197fcbcsad987s'){
    header("Location: /tablesoutput.php");
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

    <title>О сотрудниках | <?=$username?></title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
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
                <h3>General Elements</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="">
            <?php $i=0;?>
            <?php foreach ($arrUsers as $key => $value):?>
              <?$i++;?>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-align-left"></i><?=$key?><small> <?=R::findOne('users','name =?',array($key))->latin?></small></h2>
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

                    <!-- start accordion -->
                    <div class="accordion" id="accordion<?=$i?>" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingOne<?=$i?>" data-toggle="collapse" data-parent="#accordion<?=$i?>" href="#collapseOne<?=$i?>" aria-expanded="false" aria-controls="collapseOne">
                          <h4 class="panel-title">Баланс</h4>
                        </a>
                        <div id="collapseOne<?=$i?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <p>
                            <br><strong>Баланс пользователя</strong>
                            </p>
                            <?= $balance[$key]?>
                            <br>
                            <p>
                            <br><strong>Общая сумма зарплат</strong>
                            </p>
                            <?= $totalprice[$key]?>
                            <p>
                            <br><strong>Последняя зарплата</strong>
                            </p>
                            <?= $lastsalary[$key]?>
                            <p>
                            <br><strong>Дата последней зарплаты</strong>
                            </p>
                            <?= $lastpay[$key]?>
                            <p>
                            <br><strong>Количество транзакций</strong>
                            </p>
                            <?= $count_transactions[$key]?>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading" role="tab" id="headingTwo<?=$i?>" data-toggle="collapse" data-parent="#accordion<?=$i?>" href="#collapseTwo<?=$i?>" aria-expanded="true" aria-controls="collapseTwo">
                          <h4 class="panel-title">Все транзакции</h4>
                        </a>
                        <div id="collapseTwo<?=$i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" max-width="100%">
                              <thead>
                                <tr>
                                  <th>Наименование</th>
                                  <th>Сумма</th>
                              </thead>
                              <tbody>
                                <?php foreach($value as $transaction):?>
                                    <tr>
                                      <td><?=$transaction['name']?></td>
                                      <td><?=$transaction['total']?></td>
                                    </tr>
                                <?php endforeach;?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingThree<?=$i?>" data-toggle="collapse" data-parent="#accordion<?=$i?>" href="#collapseThree<?=$i?>" aria-expanded="false" aria-controls="collapseThree">
                          <h4 class="panel-title">Опции</h4>
                        </a>
                        <div id="collapseThree<?=$i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                          <div class="panel-body">
                            <form action="tablesoutput.php" method="post">
                              <input type="hidden" value="<?=$key?>" name="username">
                              <button class="btn btn-info" type="submit">Подробнее</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of accordion -->
                  </div>
                </div>
              </div>
            <?php endforeach;?>
            </div>
            <div class="clearfix"></div>

          </div>
          <div class="clearfix"></div>
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

    <div id="custom_notifications" class="custom-notifications dsp_none">
      <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
      </ul>
      <div class="clearfix"></div>
      <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
  </body>
</html>