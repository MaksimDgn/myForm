
<?php
//$str = "myName";
//$st = "2 myName";
//echo "<p>{$str}</p>";
//
//
class user {
 protected $stName;
public  $pbName="nameUser";

protected function prot(){
    $pr = " protected p() prot\n";
    echo $pr;
}

function p(){
    $a = "p() str\n";
    echo $a;
}


}
/*
//$mane1 = new User();
user::$name = "qwe";
echo user::$name;
//user::myname;
//echo user::myname;
$n = new user();
$n->myname="max";
echo $n->myname;
*/

class test extends user{
    public $q_name;
    public $q_nfo;
    public $q_n;
    public $var1 = 'value 1';
    public $var2 = 'value 2';
    public $var3 = 'value 3';


    function info(){
        parent::p();
        echo $this->stName="st Name\n";
        echo $this->pbName;
        echo $this->prot();
        $this->prot();

    }



    function serch() {
        echo "-- print foreach --\n";
        foreach ($this as $key => $value){
            print "$key => $value\n";
}
    }

}

$a= new test();
//$a->p();
$a->info();
$a->serch();



class Fww{
    //public $info;
    //public $module;

   function __construct($info, $module){
       $this->info = $info;
       $this->module = $module;
   }

   function serchKey($q, $key, $info){
       foreach ($q as $key => $info){

           if ($info == "q_n"){
               print "$key => $info\n";
           }
       }
       unset($key);//   V !!!
   }

   function serch($q,  $info){
       foreach ($q as  $info){

           if ($info == "q_n"){
               print " => $info\n";
           }
       }
       unset($info);
   }




   function ginf(){
        return   "1 "."{$this->info}\n"."2 {$this->module}\n";
   }
}

// свой массив для  module_invoke_all
$array = array(
    "on" => "q_name" ,
2 => "q_nfo",
3 => "q_n",
4 => "value 1",
5 => "value 2",
6 => "value 3",);

$n = "on";



//var_dump($us);
//echo $us->ginf()."\n\n";

//class Fww{}

$us = new Fww("aaa","a543");

// foreach key
$us->serchKey($array, $n, "value 3");
// foreach
$us->serch($array,  "value 3");

$marray = array(1, 2, 3, 4, 5);
print_r($marray);

// Теперь удаляем каждый элемент, но сам массив оставляем нетронутым:
foreach ($marray as $i => $value) {
    unset($marray[$i]);
}
print_r($marray);

// Добавляем элемент (обратите внимание, что новым ключом будет 5, вместо 0).
$marray[] = 6;
print_r($marray);

// Переиндексация:
$marray = array_values($marray);
$marray[] = 7;
print_r($marray);
?>




