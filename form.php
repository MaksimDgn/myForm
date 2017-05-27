<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>магазин - border</title>

    <link rel="stylesheet" href="sform.css">


    <script  src="jquery-migrate-1.4.1.min.js"></script>
    <script src="script.js"></script>
</head>

<body>
type="text/javascript"

<header id="page_header"><h1>Форма Входа</h1></header>

<?php
//$str = "myName";
//$st = "2 myName";
//echo "<p>{$str}</p>";
//
//
class user{
   pablic static $name;
}

//$mane1 = new User();
user::$name = "qwe";
echo user::$name;
?>



<nav id="fmenu">

    <ul class="nmenu">
        <li><a href="index.html"> Главная </a></li>
        <li><a href="guest.html"> Выход </a></li>
        <li><a href="regist.html"> Регистрации </a></li>

    </ul>

</nav>
<?php echo $st ?>


<section id="fpost">
    <ul class="mli">
        <li>  Логин:               <input type="text"> </<input></li>
        <li> Пароль:               <input type="password">   </<input></li>


    </ul>

    <input type="button" onclick="post_query('gform', 'login', 'email.password.captcha')" value="Вход"></input>


</section>
<!-- <button onclick="mw()">sdsd</button> -->



</body>
</html>