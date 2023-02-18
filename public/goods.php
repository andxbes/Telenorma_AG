<?php

class Good
{
    public $name = null;
    public $meta = null;
    public function __toString()
    {
        return $this->name . (!empty($this->meta) ? ', ' . $this->meta : '');
    }
}

header('Content-Type: application/json; charset=utf-8');

$db = new PDO('mysql:host=mariadb;dbname=beta;charset=utf8', 'beta', 'beta');

//Изначально такой запрос был, но позже обьединил в один , без создания временной таблицы
$alt_sql = "
CREATE VIEW product_meta AS(
	SELECT additional_goods_field_values.good_id AS good_id, additional_fields.name AS meta_key, additional_field_values.name AS meta_value
		FROM additional_goods_field_values
		INNER JOIN additional_fields
		ON additional_goods_field_values.additional_field_id = additional_fields.id 
		INNER JOIN additional_field_values
		ON additional_goods_field_values.additional_field_value_id = additional_field_values.id 
);

SELECT goods.name,
	GROUP_CONCAT(
		 CONCAT(product_meta.meta_key,', ',product_meta.meta_value)
    ) AS meta
FROM goods
LEFT JOIN product_meta 
ON goods.id = product_meta.good_id
group by goods.id;
";


$query = $db->query("
SELECT goods.name,
	GROUP_CONCAT(
		 CONCAT(product_meta.meta_key,', ',product_meta.meta_value)
    ) AS meta
FROM goods
LEFT JOIN ( SELECT additional_goods_field_values.good_id AS good_id, additional_fields.name AS meta_key, additional_field_values.name AS meta_value
		FROM additional_goods_field_values
		INNER JOIN additional_fields
		ON additional_goods_field_values.additional_field_id = additional_fields.id 
		INNER JOIN additional_field_values
		ON additional_goods_field_values.additional_field_value_id = additional_field_values.id )  product_meta
ON goods.id = product_meta.good_id
group by goods.id;

        ");
$query->setFetchMode(PDO::FETCH_CLASS, 'Good');
$result = $query->fetchAll();
if (!empty($result)) {
    $result = array_map(fn($good) => $good->__toString(), $result);
    print json_encode($result);
}