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
setlocale(LC_ALL, 'ru_RU');

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

<?php
//Проверяем,Что он подключен и перемещаем в безопасное место
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
            $query = "INSERT INTO test (surname, name, phone) VALUES (?,?,?)";
            $stmt = mysqli_prepare($link, $query);

            mysqli_stmt_bind_param($stmt, "sss", $data[0], $data[1], $data[2]);
            $stmt->execute();
            $stmt->close();
        }

            echo "Данные из файла были внесены в базу данных ";
            echo "<br />\n";
            echo '<a href="script2.php">Показать данные в виде таблицы</a>';

        fclose($handle);
        echo "<br />\n";
        echo "Количество внесенных строк в таблицу = " . $row;

    }

//Закрываем соединение с БД
    mysqli_close($link);
}
?>