<?php


/*

class MyData {

	private $my_arr;
	
	function __construct($data_type)
	{
		//конструктор
	}
	
	function GetData() {
		//вывод массива
	}
	
	function ArrSort($param1) {
		//сортировка
	
		return $sortedArray;
	}

}

$php_data = new MyData("php");
$php_data->GetData();

*/
// ***** функция выбора данных. Конструктор общего массива (php, json, xml) *****
function data_file($data_type){
	switch ($data_type) {
	case "php":
		// вытаскиваем данные из файла
		include_once("data/data.php");
		$data_php = $arr;		
        // преобразовываем входящие данные в нужный массив
		$i = 0;
		foreach($data_php as $country=>$currencies){	
			foreach($currencies as $code=>$attribute){
				$arr_new[$i][0] = $country;
				$arr_new[$i][1] = $code;
				$j = 2;
				foreach($attribute as $znach){
					$arr_new[$i][$j] = $znach;
					$j++;			
				}
				$i++;
			}	
		}
		return $arr_new;
        break;
    case "xml":
		// вытаскиваем данные из файла
		$data_xml = simplexml_load_file("data/data.xml");
		 // преобразовываем входящие данные в нужный массив
        $i = 0;
		foreach ($data_xml->Item as $element) {
			$arr_new[$i][0] = (string) $element['Type'];
			$arr_new[$i][1] = (string) $element->Code;
			$arr_new[$i][2] = (string) $element->Description;
			$arr_new[$i][3] = (string) $element->Value;
			$i++;
		}
		return $arr_new;		
        break;
    case "json":
		// вытаскиваем данные из файла
		$data_json = file_get_contents('data/data.json');
		$data_json = json_decode($data_json);
		// преобразовываем входящие данные в нужный массив
        $i = 0;
		foreach($data_json as $element){
			$arr_new[$i] = $element;
			$j = 1;
			foreach($element as $key=>$attribute){
				if ($j != 4) {
					$arr_new[$i][$j] = $attribute;			
				}
				else $arr_new[$i][0] = $attribute;
				$j++;
			}
			$i++;
		}
		return $arr_new;
        break;
	default:
		$array = NULL;
	}
}
// ***** конец функции выбора данных. Конструктор общего массива (php, json, xml) *****



// ***** Функция фильтра *****
function filter($arr,$continent,$code,$name,$price,$price_min,$price_max) {
	// фильтр континента (europe, world, all)
	if ($continent != 'all') {	
		$i = 0;
		foreach($arr as $element){
			if ($element[0] == $continent){
				$arr_new_0[$i] = $element;
				$j = 0;
				foreach($element as $attribute){
					$arr_new_0[$i][$j] = $attribute;
					$j++;
				}
				$i++;
			}
		}
		$arr = $arr_new_0;
	}

	// фильтр кода (заданное значение или все)
	if ($code != 'all') {	
		$i = 0;
		foreach($arr as $element){
			if ($element[1] == $code){
				$arr_new_1[$i] = $element;
				$j = 0;
				foreach($element as $attribute){
					$arr_new_1[$i][$j] = $attribute;
					$j++;
				}
				$i++;
			}
		}
		$arr = $arr_new_1;
	}

	// фильтр имени (заданное значение или все)
	if ($name != 'all') {	
		$i = 0;
		foreach($arr as $element){
			if ($element[2] == $name){
				$arr_new_2[$i] = $element;
				$j = 0;
				foreach($element as $attribute){
					$arr_new_2[$i][$j] = $attribute;
					$j++;
				}
				$i++;
			}
		}
		$arr = $arr_new_2;
	}

	// фильтр цены (заданное значение или все)
	if ($price != 'all') {	
		$i = 0;
		foreach($arr as $element){
			if ($element[3] == $price){
				$arr_new_3[$i] = $element;
				$j = 0;
				foreach($element as $attribute){
					$arr_new_3[$i][$j] = $attribute;
					$j++;
				}
				$i++;
			}
		}
		$arr = $arr_new_3;
	}
	
	// фильтр минимальной цены (заданное значение или самый минимальный)
	if ($price_min != "all") {	
		$i = 0;
		foreach($arr as $element){
			if ($element[3] >= $price_min){
				$arr_new_4[$i] = $element;
				$j = 0;
				foreach($element as $attribute){
					$arr_new_4[$i][$j] = $attribute;
					$j++;
				}
				$i++;
			}
		}
		$arr = $arr_new_4;
	}
	
	// фильтр максимальной цены (заданное значение или самый максимальный)
	if ($price_max != "all") {	
		$i = 0;
		foreach($arr as $element){
			if ($element[3] <= $price_max){
				$arr_new_5[$i] = $element;
				$j = 0;
				foreach($element as $attribute){
					$arr_new_5[$i][$j] = $attribute;
					$j++;
				}
				$i++;
			}
		}
		$arr = $arr_new_5;
	}
	
	return $arr;
}
// ***** конец функции фильтра *****



// ***** функция сортировки ($array - массив, $attribute - по какому полю сортируем, $sort - по возрастанию или по убыванию)*****
function sort_array($array,$attribute,$sort) {
	if ($attribute == 'continent') $key = 0;
	elseif ($attribute == 'code') $key = 1;
	elseif ($attribute == 'name') $key = 2;
	elseif ($attribute == 'price') $key = 3;
	$max=count($array);
	for($i=0;$i<$max;$i++){
		for($j=0; $j<$max-1-$i; $j++){
			if ($sort == 'asc'){	
				if ($array[$j+1][$key]<$array[$j][$key]){
					list($array[$j], $array[$j+1])=array($array[$j+1],$array[$j]);
				}
			}
			elseif ($sort == 'desc') {
				if ($array[$j+1][$key]>$array[$j][$key]){
					list($array[$j], $array[$j+1])=array($array[$j+1],$array[$j]);
				}
			}
		}
	}
	return $array;
}
// ***** конец функции сортировки *****

?>
