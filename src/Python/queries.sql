-- toutes les vues de la base 
select f.* from `field` f left join `table` t on f.for_table_id = t.id WHERE t.is_view = 1 ORDER BY f.for_table_id asc;

--trouver le champ correspondant
select f.* from `field` f left join `table` t on f.for_table_id = t.id where t.name = "" and f.name =""

-- trouver les champs qui ont rencontrés des difficultés à être automatiquement résolus
SELECT count(f.id) FROM `field` f left join `table` t on t.id = f.for_table_id where t.is_view = 1 and use_property_id is NOT NULL;
SELECT count(f.id) FROM `field` f left join `table` t on t.id = f.for_table_id where t.is_view = 1 and use_property_id is NULL;

--trouver le nombre de tables qui ont rencontrés des difficultés à être automatiquement résolus
SELECT count(DISTINCT t.id) FROM `field` f left join `table` t on t.id = f.for_table_id where t.is_view = 1 and use_property_id is NOT NULL;
SELECT count(DISTINCT t.id) FROM `field` f left join `table` t on t.id = f.for_table_id where t.is_view = 1 and use_property_id is NULL;

-- classement des propriétés les plus utilisées pour les vues
SELECT count(f.id),f.use_property_id FROM `field` f left join `table` t on t.id = f.for_table_id where t.is_view = 1 group by f.use_property_id  
ORDER BY `count(f.id)` DESC;

-- met en avant des champs qui sont issus d'une vue, et qui sont utilisés par une autre vue
SELECT count(f.id),f.use_property_id 
FROM `field` f 
left join `table` t on t.id = f.for_table_id 
left join `field` f2 ON f.use_property_id = f2.id 
left join `table` t2 ON t2.id = f2.for_table_id  
where t.is_view = 1 AND t2.is_view = 1
group by f.use_property_id  
ORDER BY `count(f.id)` DESC;
-- debug
SELECT f.id as f_id,CONCAT(t.id,"=>",t.name) as t_name_id,t.is_view as t_is_view,f.use_property_id as f_usePropId,f2.id as f2_id, CONCAT(t2.id,"=>",t2.name) as t2_name_id,t2.is_view as t2_is_view
FROM `field` f 
left join `table` t on t.id = f.for_table_id 
left join `field` f2 ON f.use_property_id = f2.id 
left join `table` t2 ON t2.id = f2.for_table_id  
where t.is_view = 1 AND t2.is_view = 0

-- remonter la chaine de dépendance d'un champ vis ) vis d'autres
SELECT f.id as f_id,CONCAT(t.id,"=>",t.name) as t_name_id,t.is_view as t_is_view,f.use_property_id as f_usePropId,f2.id as f2_id, CONCAT(t2.id,"=>",t2.name) as t2_name_id,t2.is_view as t2_is_view,f3.id as f3_id, CONCAT(t3.id,"=>",t3.name) as t3_name_id,t3.is_view as t3_is_view
FROM `field` f 
left join `table` t on t.id = f.for_table_id 
left join `field` f2 ON f.use_property_id = f2.id 
left join `table` t2 ON t2.id = f2.for_table_id

left join `field` f3 ON f2.use_property_id = f3.id 
left join `table` t3 ON t3.id = f3.for_table_id  
where t.is_view = 1 AND t2.is_view = 1 AND t3.is_view = 0;
