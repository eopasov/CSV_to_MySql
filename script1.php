<!DOCTYPE html>
<html>
<head>
    <title>CSV to MySQL</title>
</head>
<body>
<form enctype="multipart/form-data" action="script1.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <input name="userfile" type="file">
    <input type="submit" value="Загрузить">
</form>
</body>
</html>


<?php

//устанавливаем локаль
setlocale (LC_ALL, 'nl_NL');

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

?>

<!--Проверяем,Что он подключен и перемещаем в безопасное место -->

<?php
if(empty($_FILES)){
    echo "Выберите файл";
}
else {
    $uploaddir = '';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    echo '<pre>';
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "Файл корректен и был успешно загружен.<br/>\n";
    } else {
        //echo "Возможная атака с помощью файловой загрузки!\n";
    }
    print "</pre>";


//работа с csv файлом

    $row = 0;
    $sql = "";
    if (($handle = fopen($uploadfile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $row++;
            $sql = mysqli_query($link, "INSERT INTO `test` SET
                `surname` = '$data[0]',
                `name` = '$data[1]',
                `phone` = '$data[2]';
               
              ");

        }
        if ($sql) {
            echo "data uploaded successfully ";
            echo "<br />\n";
            echo '<a href="script2.php">Показать данные в виде таблицы</a>';

    }
        fclose($handle);
        echo "<br />\n";
        echo "Количество внесенных строк в таблицу = " . $row;

    }

//Закрываем соединение с БД
    mysqli_close($link);
}
?>