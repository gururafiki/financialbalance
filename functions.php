<?php
    //Скачать библиотеку - http://phpexcel.codeplex.com/
    //Нашел русскую документацию - http://www.cyberforum.ru/php-beginners/thread1074684.html
    //Подключаем скачаную библиотеку
    require "db.php";
    $tr = [
        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d",
        "Е"=>"e","Ё"=>"yo","Ж"=>"j","З"=>"z","И"=>"i",
        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"c","Ч"=>"ch",
        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
        " "=> "", "."=> "", "/"=> "_",
        "A"=>"a","B"=>"b","C"=>"c","D"=>"d",
        "E"=>"e","F"=>"f","G"=>"g","H"=>"h",
        "I"=>"i","J"=>"j","K"=>"k","L"=>"l",
        "M"=>"m","N"=>"n","O"=>"o","P"=>"p",
        "Q"=>"q","R"=>"r","S"=>"s","T"=>"t",
        "U"=>"u","V"=>"v","W"=>"w","X"=>"x",
        "Y"=>"y","Z"=>"z"
    ];
    //ispersonal=0 => на расходы компании(изменить баланс) ispersonal=1 => на расходы сотрудника (изменить стоимость сотрудника)
    function buy_product($name,$count,$price,$stock,$ispersonal){ // кол-во продукта + , общая стоимость продукта + , баланс пользователя -
        $product=R::findOne('products','name = ? AND stock = ?',array($name,$stock));
        if(!isset($product->id)){
            $product = R::dispense('products');
            $product->name=$name;
            $product->stock=$stock;
            $product->ispersonal=$ispersonal;
        }
        $product->count+=$count;
        $product->totalprice+=$price*$count; 
        R::store($product);
    }

    function update_product(){ // изменить баланс , добавить транзакцию
        echo "empty";
    }
    
    function sell_product($name,$count,$price,$stock,$ispersonal){ // кол-во продукта - , общая стоимость продукта - , баланс пользователя +
        $product=R::findOne('products','name = ? AND stock = ?',array($name,$stock));
        if(!isset($product->id)){
            $product = R::dispense('products');
            $product->name=$name;
            $product->stock=$stock;
            $product->ispersonal=$ispersonal;
        }
        $product->count-=$count;
        $product->totalprice+=$price*$count; 
        R::store($product);
    }
    
    function take_money($stockname,$type,$name,$taker,$giver,$count,$price,$info,$ispersonal,$tr,$balance){ // баланс пользователя + , баланс сотрудника -
        $taker_latin = $taker;
        $taker_latin = strtr($taker_latin,$tr);
        $taker_latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $taker_latin);

        $transaction = R::dispense($taker_latin);
        $transaction->type = $type;
        $transaction->name = $name;
        $transaction->giver = $giver;
        $transaction->taker = $taker;
        $transaction->count = $count; 
        $transaction->price = $price; 
        $transaction->stockname = $stockname;
        $transaction->ispersonal = $ispersonal;
        $transaction->balance = $balance; 
        $transaction->total = $price*$count; 
        if($name!='Деньги' && $type!='Отмена продажи' && $type!='Отмена покупки')
            $transaction->description = $taker.' продал "'.$name.'" на сумму '.$transaction->total.' ₴ .Покупатель '.$giver;
        elseif($name=='Деньги' && $type!='Отмена продажи' && $type!='Отмена покупки')
            $transaction->description = $taker.' взял '.$transaction->total.' ₴ у '.$giver;
        elseif($name!='Деньги' && $type=='Отмена продажи')
            $transaction->description = $giver.' отменил продажу "'.$name.'" на сумму '.$transaction->total.' ₴ у продавца '.$taker; 
        elseif($name!='Деньги' && $type=='Отмена покупки') 
            $transaction->description = $taker.' отменил покупку "'.$name.'" на сумму '.$transaction->total.' ₴ у продавца '.$giver; 
        elseif($name=='Деньги')
            $transaction->description = $giver.' отменил транзакцию на сумму '.$transaction->total.' ₴ с '.$taker;  
        $transaction->info = $info;
        $transaction->date=date("d.m.Y (H:i:s)", time());
        $transaction->day=date("d", time());
        $transaction->month=date("m", time());
        $transaction->year=date("Y", time());

        R::store($transaction);
    }

    function give_salary($taker,$giver,$count,$price,$info,$tr,$balance){// баланс пользователя - , баланс сотрудника +
        $giver_latin = $giver;
        $giver_latin = strtr($giver_latin,$tr);
        $giver_latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $giver_latin);

        $transaction = R::dispense($giver_latin);
        $transaction->type = $type;
        $transaction->name = 'Выплата зарплаты';
        $transaction->taker = $taker;
        $transaction->giver = $giver;
        $transaction->count = $count; 
        $transaction->price = $price; 
        $transaction->balance = $balance; 
        $transaction->total = $price*$count; 
        $transaction->description = $giver.' выплатил зарплату на сумму '.-$transaction->total.' ₴ сотруднику '.$taker;
        $transaction->info = $info;
        $transaction->date=date("d.m.Y (H:i:s)", time());
        $transaction->day=date("d", time());
        $transaction->month=date("m", time());
        $transaction->year=date("Y", time());

        $worker=R::findOne('users','name = ?',array($taker));
        $worker->totalprice-=$price*$count;
        $worker->lastsalary-=$price*$count;
        $worker->lastpay=date("d.m.Y (H:i:s)", time());
        R::store($worker);
        R::store($transaction);
    }
    
    function give_money($stockname,$type,$name,$taker,$giver,$count,$price,$info,$ispersonal,$tr,$balance){// баланс пользователя - , баланс сотрудника +
        $giver_latin = $giver;
        $giver_latin = strtr($giver_latin,$tr);
        $giver_latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $giver_latin);

        $transaction = R::dispense($giver_latin);
        $transaction->type = $type;
        $transaction->name = $name;
        $transaction->taker = $taker;
        $transaction->giver = $giver;
        $transaction->count = $count; 
        $transaction->price = $price; 
        $transaction->stockname = $stockname;
        $transaction->ispersonal = $ispersonal;
        $transaction->balance = $balance; 
        $transaction->total = $price*$count; 
        if($name!='Деньги' && $type!='Отмена продажи' && $type!='Отмена покупки')
            $transaction->description = $giver.' купил "'.$name.'" на сумму '.-$transaction->total.' ₴ у '.$taker;
        elseif($name=='Деньги' && $type!='Отмена продажи' && $type!='Отмена покупки')
            $transaction->description = $giver.' отдал '.-$transaction->total.' ₴ '.$taker;  
        elseif($name!='Деньги' && $type=='Отмена продажи')
            $transaction->description = $giver.' отменил продажу "'.$name.'" на сумму '.$transaction->total.' ₴ у продавца '.$taker; 
        elseif($name!='Деньги' && $type=='Отмена покупки') 
            $transaction->description = $taker.' отменил покупку "'.$name.'" на сумму '.$transaction->total.' ₴ у продавца '.$giver; 
        elseif($name=='Деньги')
            $transaction->description = $giver.' отменил транзакцию на сумму '.$transaction->total.' ₴ с '.$taker;     
        $transaction->info = $info;
        $transaction->date=date("d.m.Y (H:i:s)", time());
        $transaction->day=date("d", time());
        $transaction->month=date("m", time());
        $transaction->year=date("Y", time());

        R::store($transaction);
    }
    
    function update_second($secondperson,$count,$price,$ispersonal,$tr){//изменить баланс,добавить транзакцию
        $second_latin = $secondperson;
        $second_latin = strtr($second_latin,$tr);
        $second_latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $second_latin);
        $second=R::findOne('users','latin = ?',array($second_latin));
        $balance[1]='user';
        if(!isset($second)){
            $second=R::findOne('secondpersons','latin = ?',array($second_latin));
            $balance[1]='secondperson';
        }
        if(!isset($second->id)){
            $balance[1]='secondperson';
            $second = R::dispense('secondpersons');
            $second->name=$secondperson;
            $second->latin=$second_latin;
        }
        if( $ispersonal ){
            $second->totalprice+=$price*$count;
        }
        $second->balance+=$price*$count;
        $balance[0]=$second->balance;
        R::store($second);
        return $balance;
    }
    
    function update_worker($name,$balance,$level,$price,$tr,$password){//регистрация
        $user = R::dispense('users');
        $user->name=$name;
        $user->balance=$balance;
        $user->level=$level;
        $user->totalprice=$price;
        $name_latin = strtr($name,$tr);
        $name_latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $name_latin);
        $user->latin=$name_latin;
        $user->password=$password;
        R::store($user);
    }
    
    function add_transaction($type,$ispersonal,$product_name,$taker,$giver,$count,$price,$info,$status,$confirmator){// после покупки,продажи,выдачи денег

        $transaction = R::dispense('transactions');
        $transaction->type=$type;
        $transaction->name = $product_name;
        $transaction->taker = $taker;
        $transaction->giver = $giver;
        $transaction->ispersonal = $ispersonal;
        $transaction->count = $count; 
        $transaction->price = $price; 
        $transaction->total = $price*$count; 
        $transaction->info = $info;
        $transaction->date=date("d.m.Y (H:i:s)", time());
        $transaction->day=date("d", time());
        $transaction->month=date("m", time());
        $transaction->year=date("Y", time());
        $transaction->status=$status;
        $transaction->confirmator=$confirmator;
        R::store($transaction);
    }
    function confirm_transaction($name,$id){
        $transaction=R::findOne('transactions','status = ? AND id = ? AND confirmator = ?',array('waiting',$id,$name));
        $transaction->status='confirmed';
        R::store($transaction);
    }
    function cancel_transaction($username,$id,$tr){
        $username_latin = $username;
        $username_latin = strtr($username_latin,$tr);
        $username_latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $username_latin);
        return R::findOne($username_latin,'id = ?',array($id));
    }

    $type=$_POST['type'];


    $username=$_SESSION['name'];
    $ispersonal=$_POST['ispersonal'];
    $level=$_SESSION['level'];


    if($_POST['secondperson']=='customsecondperson')
        $secondperson=$_POST['customsecondperson'];
    else
        $secondperson=$_POST['secondperson'];



    if($_POST['productname']=='customproductname')
        $productname=$_POST['customproductname'];
    else
        $productname=$_POST['productname'];



    if($_POST['stockname']=='customstockname')
        $_POST['stockname']=$_POST['customstockname'];


    $stockname=$_POST['stockname'];
    $_POST['ispersonal']=0;
    if($ispersonal==1)
        $_POST['stockname']=$username;

    if($_POST['type']=='cancel'){
        $cancel_transaction=cancel_transaction($_POST['username'],$_POST['id'],$tr);
        if($_SESSION['name']!=$_POST['username'])
            $info='(Сделал администратор '.$_SESSION['name'].')';
        
        if($cancel_transaction->type=='take'){
            $balance=update_second($cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,0,$tr);
            give_money($cancel_transaction->stockname,'Отмена транзакции',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->taker.' . id: '.$cancel_transaction->id.$info,0,$tr,$balance[0]);
            add_transaction('Отмена транзакции',0,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->taker.' . id: '.$cancel_transaction->id.$info,'confirmed',$cancel_transaction->taker);
            $balance=update_second($cancel_transaction->giver,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            take_money($cancel_transaction->stockname,'Отмена транзакции',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->taker.' . id: '.$cancel_transaction->id.$info,$cancel_transaction->ispersonal,$tr,$balance[0]);
            add_transaction('Отмена транзакции',$ispersonal,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->taker.' . id: '.$cancel_transaction->id.$info,'waiting',$cancel_transaction->giver);  
        }
        elseif($cancel_transaction->type=='give'){
            $balance=update_second($cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            give_money($cancel_transaction->stockname,'Отмена транзакции',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,0,$tr,$balance[0]);
            if($_SESSION['name']!=$_POST['username'])
                add_transaction('Отмена транзакции',$cancel_transaction->ispersonal,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,'confirm',$cancel_transaction->giver);
            else
                add_transaction('Отмена транзакции',$cancel_transaction->ispersonal,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.'(подтвердил возврат средств)','confirm',$cancel_transaction->giver);

            $balance=update_second($cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            take_money($cancel_transaction->stockname,'Отмена транзакции',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,$cancel_transaction->ispersonal,$tr,$balance[0]);
            add_transaction('Отмена транзакции',$cancel_transaction->ispersonal,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,$cancel_transaction->price,'Отмена транзакции пользователя '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,'waiting',$cancel_transaction->taker);

        }
        elseif($cancel_transaction->type=='sell'){
            $balance=update_second($cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            give_money($cancel_transaction->stockname,'Отмена продажи',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->taker.' отменил продажу "'.$cancel_transaction->name.'" на сумму '.$cancel_transaction->total.' покупателю '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,$cancel_transaction->ispersonal,$tr,$balance[0]);
            $balance=update_second($cancel_transaction->giver,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            if($balance[1]=='user'){
                if($_SESSION['name']!=$_POST['username'])
                    take_money($cancel_transaction->stockname,'Отмена продажи',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->taker.' отменил продажу "'.$cancel_transaction->name.'" на сумму '.$cancel_transaction->total.' покупателю '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info, $cancel_transaction->ispersonal,$tr,$balance[0]);
                else
                    take_money($cancel_transaction->stockname,'Отмена продажи',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->taker.' отменил продажу "'.$cancel_transaction->name.'" на сумму '.$cancel_transaction->total.' покупателю '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.'(сделано '.$cancel_transaction->taker.')', $cancel_transaction->ispersonal,$tr,$balance[0]);
                add_transaction('Отмена продажи',$ispersonal,$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->taker.' отменил продажу "'.$cancel_transaction->name.'" на сумму '.$cancel_transaction->total.' покупателю '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,'waiting',$cancel_transaction->giver);  
                sell_product($cancel_transaction->name,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->giver,$ispersonal);
            }
            buy_product($cancel_transaction->name,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->stockname,$cancel_transaction->ispersonal);
            add_transaction('Отмена продажи',$ispersonal,$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->taker.' отменил продажу "'.$cancel_transaction->name.'" на сумму '.$cancel_transaction->total.' покупателю '.$cancel_transaction->giver.' id: '.$cancel_transaction->id.$info,'confirmed',$cancel_transaction->taker);
        }
        elseif($cancel_transaction->type=='buy'){     
            //giver-дал деньги (покупатель(я)) taker - продавец (он)  
            $balance=update_second($cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            take_money($cancel_transaction->stockname,'Отмена покупки',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,'Отмена покупки "'.$cancel_transaction->name.'" у '.$cancel_transaction->taker.' на сумму '.-$cancel_transaction->total.' id: '.$cancel_transaction->id.$info,$cancel_transaction->ispersonal,$tr,$balance[0]);
            sell_product($cancel_transaction->name,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->stockname,$ispersonal);
            $balance=update_second($cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
            if($balance[1]=='user'){
                buy_product($cancel_transaction->name,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->taker,$cancel_transaction->ispersonal);
                if($_SESSION['name']!=$_POST['username'])
                    give_money($cancel_transaction->stockname,'Отмена покупки',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,'Отмена покупки "'.$cancel_transaction->name.'" у '.$cancel_transaction->taker.' на сумму '.-$cancel_transaction->total.' id: '.$cancel_transaction->id.$info, $cancel_transaction->ispersonal,$tr,$balance[0]);
                else
                    give_money($cancel_transaction->stockname,'Отмена покупки',$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,'Отмена покупки "'.$cancel_transaction->name.'" у '.$cancel_transaction->taker.' на сумму '.-$cancel_transaction->total.'(сделано '.$cancel_transaction->giver.')', $cancel_transaction->ispersonal,$tr,$balance[0]);
                add_transaction('Отмена покупки',$ispersonal,$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,'Отмена покупки "'.$cancel_transaction->name.'" у '.$cancel_transaction->taker.' на сумму '.-$cancel_transaction->total.' id: '.$cancel_transaction->id.$info,'waiting',$cancel_transaction->taker);  
            }
            add_transaction('Отмена покупки',$ispersonal,$cancel_transaction->name,$cancel_transaction->giver,$cancel_transaction->taker,$cancel_transaction->count,-$cancel_transaction->price,'Отмена покупки "'.$cancel_transaction->name.'" у '.$cancel_transaction->taker.' на сумму '.-$cancel_transaction->total.' id: '.$cancel_transaction->id.$info,'confirmed',$cancel_transaction->giver);
        }
        header("Location: /".@$_SERVER['HTTP_REFERER']);
    }
    elseif($_POST['type']=='buy'){
        $balance=update_second($username,$_POST['count'],-$_POST['price'],$_POST['ispersonal'],$tr);
        give_money($stockname,$type,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        $balance=update_second($secondperson,$_POST['count'],$_POST['price'],$_POST['ispersonal'],$tr);
        if($balance[1]=='user'){
            take_money($stockname,$type,$productname,$secondperson,$username,$_POST['count'],$_POST['price'],$_POST['info'].'(сделано '.$username.')', $_POST['ispersonal'],$tr,$balance[0]);
            add_transaction($type,$ispersonal,$productname,$secondperson,$username,$_POST['count'],$_POST['price'],$_POST['info'],'waiting',$secondperson);  
            sell_product($productname,$_POST['count'],-$_POST['price'],$secondperson,$ispersonal);
        }
        buy_product($productname,$_POST['count'],$_POST['price'],$_POST['stockname'],$_POST['ispersonal']);
        add_transaction($type,$ispersonal,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],'confirmed',$username);
    }
    elseif($_POST['type']=='sell'){
        $balance=update_second($username,$_POST['count'],$_POST['price'],$_POST['ispersonal'],$tr);
        take_money($stockname,$type,$productname,$username,$secondperson,$_POST['count'],$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        sell_product($productname,$_POST['count'],-$_POST['price'],$_POST['stockname'],$ispersonal);
        $balance=update_second($secondperson,$_POST['count'],-$_POST['price'],$_POST['ispersonal'],$tr);
        if($balance[1]=='user'){
            buy_product($productname,$_POST['count'],$_POST['price'],$secondperson,$_POST['ispersonal']);
            give_money($stockname,$type,$productname,$username,$secondperson,$_POST['count'],-$_POST['price'],$_POST['info'].'(сделано '.$username.')', $_POST['ispersonal'],$tr,$balance[0]);
            add_transaction($type,$ispersonal,$productname,$username,$secondperson,$_POST['count'],-$_POST['price'],$_POST['info'],'waiting',$secondperson);  
        }
        add_transaction($type,$ispersonal,$productname,$username,$secondperson,$_POST['count'],$_POST['price'],$_POST['info'],'confirmed',$username);
    }
    elseif($_POST['type']=='give' && $level=='SAD38742987aS679as'){
        $balance=update_second($username,$_POST['count'],-$_POST['price'],0,$tr);
        give_money($stockname,$type,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],0,$tr,$balance[0]);
        add_transaction($type,0,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],'confirmed',$username);
        $balance=update_second($secondperson,$_POST['count'],$_POST['price'],$_POST['ispersonal'],$tr);
        take_money($stockname,$type,$productname,$secondperson,$username,$_POST['count'],$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$secondperson,$username,$_POST['count'],$_POST['price'],$_POST['info'],'confirmed',$username);  
    }
    elseif($_POST['type']=='take' && $level=='SAD38742987aS679as'){ 
        $balance=update_second($secondperson,$_POST['count'],-$_POST['price'],0,$tr);
        give_money($stockname,$type,$productname,$username,$secondperson,$_POST['count'],-$_POST['price'],$_POST['info'],0,$tr,$balance[0]);
        add_transaction($type,0,$productname,$username,$secondperson,$_POST['count'],-$_POST['price'],$_POST['info'].'(отдал)','confirmed',$username);
        $balance=update_second($username,$_POST['count'],$_POST['price'],$_POST['ispersonal'],$tr);
        take_money($stockname,$type,$productname,$username,$secondperson,$_POST['count'],$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$username,$secondperson,$_POST['count'],$_POST['price'],$_POST['info'].'(подтвердил получение)','confirmed',$username);
    }
    elseif($_POST['type']=='take'){ 
        $balance=update_second($secondperson,$_POST['count'],-$_POST['price'],$ispersonal,$tr);
        give_money($stockname,$type,$productname,$username,$secondperson,$_POST['count'],-$_POST['price'],$_POST['info'],0,$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$username,$secondperson,$_POST['count'],-$_POST['price'],$_POST['info'],'waiting',$secondperson);  
        $balance=update_second($username,$_POST['count'],$_POST['price'],$_POST['ispersonal'],$tr);
        take_money($stockname,$type,$productname,$username,$secondperson,$_POST['count'],$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$username,$secondperson,$_POST['count'],$_POST['price'],$_POST['info'].'(подтвердил получение)','confirmed',$username);
    }
    elseif($_POST['type']=='give'){
        $balance=update_second($username,$_POST['count'],-$_POST['price'],$_POST['ispersonal'],$tr);
        give_money($stockname,$type,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],'confirmed',$username);
        $balance=update_second($secondperson,$_POST['count'],$_POST['price'],$_POST['ispersonal'],$tr);
        take_money($stockname,$type,$productname,$secondperson,$username,$_POST['count'],$_POST['price'],$_POST['info'],$_POST['ispersonal'],$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$secondperson,$username,$_POST['count'],$_POST['price'],$_POST['info'],'waiting',$secondperson);  
    }
    elseif($_POST['type']=='salary'){
        $balance=update_second($username,$_POST['count'],-$_POST['price'],$_POST['ispersonal'],$tr);
        //($taker,$giver,$count,$price,$info,$tr,$balance)
        give_salary($secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'],$tr,$balance[0]);
        add_transaction($type,$ispersonal,$productname,$secondperson,$username,$_POST['count'],-$_POST['price'],$_POST['info'].'(зарплата)','confirmed',$username); 
    }
    elseif($_POST['type']=='confirm'){
        confirm_transaction($_POST['name'],$_POST['id']);
    }
        // if($cancel_transaction->type=='buy'){
        //     $cancel_transaction->price=-$cancel_transaction->price;
        //     $balance=update_second($cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
        //     give_money($cancel_transaction->stockname,'Отмена транзакции',$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->info,$cancel_transaction->ispersonal,$tr,$balance[0]);
        //     $balance=update_second($cancel_transaction->taker,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->ispersonal,$tr);
        //     if($balance[1]=='user'){
        //         take_money($cancel_transaction->stockname,'Отмена транзакции',$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->info.'(Отмена транзакции пользователя '.$_POST['username'].' .id:'.$_POST['id'].')', $cancel_transaction->ispersonal,$tr,$balance[0]);
        //         add_transaction('Отмена транзакции',$cancel_transaction->ispersonal,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->info,'waiting',$cancel_transaction->taker);  
        //         sell_product($cancel_transaction->name,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->taker,$cancel_transaction->ispersonal);
        //     }
        //     buy_product($cancel_transaction->name,$cancel_transaction->count,$cancel_transaction->price,$cancel_transaction->stockname,$cancel_transaction->ispersonal);
        //     add_transaction('Отмена транзакции',$cancel_transaction->ispersonal,$cancel_transaction->name,$cancel_transaction->taker,$cancel_transaction->giver,$cancel_transaction->count,-$cancel_transaction->price,$cancel_transaction->info,'confirmed',$cancel_transaction->giver);
        // }
    header("Location: /tablesoutput.php");
?>