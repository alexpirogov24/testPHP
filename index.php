<?php
// получаем данные из формы фильтра и присваим их переменным. Если переменной не существует или она пустая, то присваем значение по умолчанию.
if ( (!isset($_POST['data_type'])) or ($_POST['data_type'] == '') ) $data_type = 'php'; else $data_type = $_POST['data_type'];
if ( (!isset($_POST['continent'])) or ($_POST['continent'] == '') ) $continent = 'all'; else $continent = $_POST['continent'];
if ( (!isset($_POST['code'])) or ($_POST['code'] == '') ) $code = 'all'; else $code = $_POST['code'];
if ( (!isset($_POST['name'])) or ($_POST['name'] == '') ) $name = 'all'; else $name = $_POST['name'];
if ( (!isset($_POST['price'])) or ($_POST['price'] == '') ) $price = 'all'; else $price = $_POST['price'];
if ( (!isset($_POST['price_min'])) or ($_POST['price_min'] == '') ) $price_min = 'all'; else $price_min = $_POST['price_min'];
if ( (!isset($_POST['price_max'])) or ($_POST['price_max'] == '') ) $price_max = 'all'; else $price_max = $_POST['price_max'];
if ( (!isset($_POST['attribute'])) or ($_POST['attribute'] == '') ) $attribute = 'world'; else $attribute = $_POST['attribute'];
if ( (!isset($_POST['sort'])) or ($_POST['sort'] == '') ) $sort = 'asc'; else $sort = $_POST['sort'];

include_once("function.php");

$data_php = data_file($data_type); // создаем общий массив по типу файла (php, json, xml)
$array = filter($data_php,$continent,$code,$name,$price,$price_min,$price_max); // фильтруем данные (массив, континент, код, имя, цена, минимальная цена, максимальная цена)
$array = sort_array($array,$attribute,$sort); // сортируем данные (массив, по какому полю сортировать, по возрастанию или по убыванию)
?>

<!-- Форма фильтра -->
<form name="filter" action="/testovoe/" method="POST">
	Выбирите тип данных:<br>
	<select name="data_type">
		<option <?php if($data_type == 'php') echo 'selected=""'; ?> value="php">php</option>
		<option <?php if($data_type == 'json') echo 'selected=""'; ?> value="json">json</option>
		<option <?php if($data_type == 'xml') echo 'selected=""'; ?> value="xml">xml</option>
	</select><br>
	Выбирите континент:<br>
	<select name="continent">
		<option <?php if($continent == 'all') echo 'selected=""'; ?> value="all">all</option>
		<option <?php if($continent == 'world') echo 'selected=""'; ?> value="world">world</option>
		<option <?php if($continent == 'europe') echo 'selected=""'; ?> value="europe">europe</option>
	</select><br>
	Введите код валюты:<br>
	<input type="text"  <?php if($_POST['code'] != '') echo 'value="'.$code.'"'; ?>  size="10" name="code"><br>
	Введите имя валюты:<br>
	<input type="text" <?php if($_POST['name'] != '') echo 'value="'.$name.'"'; ?> size="20" name="name"><br>
	Введите цену валюты:<br>
	<input type="text" <?php if($_POST['price'] != '') echo 'value="'.$price.'"'; ?> size="5" name="price"><br>
	Введите границы цены валюты
	<input type="text" <?php if($_POST['price_min'] != '') echo 'value="'.$price_min.'"'; ?> size="5" name="price_min"> - 
	<input type="text" <?php if($_POST['price_max'] != '') echo 'value="'.$price_max.'"'; ?> size="5" name="price_max"><br>
	Сортировка:<br>
	<select name="attribute">
		<option <?php if($attribute == 'continent') echo 'selected=""'; ?> value="continent">По континенту</option>
		<option <?php if($attribute == 'code') echo 'selected=""'; ?> value="code">По коду</option>
		<option <?php if($attribute == 'name') echo 'selected=""'; ?> value="name">По имени</option>
		<option <?php if($attribute == 'price') echo 'selected=""'; ?> value="price">По цене</option>
	</select> 
	<select name="sort">
		<option <?php if($sort == 'asc') echo 'selected=""'; ?> value="asc">По возрастанию</option>
		<option <?php if($sort == 'desc') echo 'selected=""'; ?> value="desc">По убыванию</option>
	</select> </br>
	<input type="submit" value="Фильтр" name="Submit">
</form>
<!-- Конец формы фильтра -->


</br></br>
<?php
// Вывод результата
if ($array == NULL) {?>
	<h2>По данному фильтру не найдено не одного елемента.</h2>
<?php }
else {?>
	<table border="1">
		<tr>
			<td>Континент</td>
			<td>Код</td>
			<td>Название</td>
			<td>Цена</td>
		</tr>
		<?php foreach($array as $element){?>
			<tr>
				<?php foreach($element as $attribute){?>
					<td><?php echo $attribute; ?></td>
				<?php }?>
			</tr>
		<?php }?>
	</table>
<?php }?>
