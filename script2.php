<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <title>Тег table</title>
  <style type="text/css">
      table {
          font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
          text-align: left;
          border-collapse: separate;
          border-spacing: 5px;
          background: #ECE9E0;
          color: #656665;
          border: 16px solid #ECE9E0;
          border-radius: 20px;
      }
      th {
          font-size: 18px;
          padding: 10px;
      }
      td {
          background: #F5D7BF;
          padding: 10px;
      }
  </style>
 </head>

<?php

//Настройки подключения к БД

$host= 'localhost';
$database='data';
$user= 'root';
$password= 'root';

//Подключаемся к БД

$link = mysqli_connect($host,$user,$password,$database);
if ($link == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
else {
    print("Соединение с базой данных установлено успешно<br/>\n");
}


$sql = 'SELECT surname,name,phone FROM test';

$result = mysqli_query($link, $sql);

//while ($row = mysqli_fetch_array($result)) {
    //print("Фамилия: " . $row['surname'] . "; Имя: " .$row['name']. "; Телефон:  " . $row['phone'] . "<br>");
//}
?>
 <table>
     <tr>
         <td >Фамилия</td>
         <td>Имя</td>
         <td>Телефон</td>
     </tr>
<?php
     while ($row = mysqli_fetch_array($result)) {
?>
         <tr>
             <td><?php echo $row['surname']; ?></td>
             <td><?php echo $row['name']; ?></td>
             <td><?php echo $row['phone']; ?></td>
         </tr>
         <?php
     }

?>
 </table>

 <?php
//Закрываем соединение с БД
mysqli_close($link);
?>
