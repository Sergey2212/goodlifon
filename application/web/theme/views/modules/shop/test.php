

SELECT `property_static_values`.`id`, `property_static_values`.`name`, `value`, `property_static_values`.`slug` FROM `property_static_values` INNER JOIN `object_static_values` ON `object_static_values`.property_static_value_id=`property_static_values`.id INNER JOIN `product_category` ON `product_category`.object_model_id = `object_static_values`.object_model_id INNER JOIN `product` `p` ON p.id = `product_category`.object_model_id AND p.active = 1 AND p.parent_id = 0 WHERE (`property_static_values`.`property_id`=7) AND (`property_static_values`.`dont_filter`=0) AND (`product_category`.`category_id`=8) ORDER BY `property_static_values`.`sort_order`, `property_static_values`.`name`


SELECT `property_static_values`.`id` FROM `property_static_values` INNER JOIN `object_static_values` ON `object_static_values`.property_static_value_id = `property_static_values`.id WHERE (`property_id`=7) AND (`object_static_values`.object_model_id IN (SELECT DISTINCT `object_static_values`.`object_model_id` FROM `object_static_values` WHERE `object_id`=3))


SELECT `property_static_values`.`id`, `property_static_values`.`name`, `value`, `property_static_values`.`slug` FROM `property_static_values` INNER JOIN `object_static_values` ON `object_static_values`.property_static_value_id=`property_static_values`.id INNER JOIN `product_category` ON `product_category`.object_model_id = `object_static_values`.object_model_id INNER JOIN `product` `p` ON p.id = `product_category`.object_model_id AND p.active = 1 WHERE (`property_static_values`.`property_id`=8) AND (`property_static_values`.`dont_filter`=0) AND (`product_category`.`category_id`=16) ORDER BY `property_static_values`.`sort_order`, `property_static_values`.`name`