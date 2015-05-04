SELECT CEILING(Total_InnoDB_Bytes*1.6/POWER(1024,3)) RIBPS FROM
(SELECT SUM(data_length+index_length) Total_InnoDB_Bytes
FROM information_schema.tables WHERE engine='InnoDB') A;

# 1. Смежный список id - parent_id

# Все дочерние категории
SELECT * FROM categories cat1
LEFT JOIN categories cat2
 ON (cat2.parent_id = cat1.id);

# Все родительские категории
SELECT * FROM categories cat1
LEFT JOIN categories cat2
 ON (cat1.parent_id = cat2.id); 