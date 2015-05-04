SELECT category.title, (COUNT(parent.title) - 1) AS depth
    FROM categories AS category,
            categories AS parent
    WHERE category.lft BETWEEN parent.lft AND parent.rgt
    GROUP BY category.title
    ORDER BY category.lft;

SELECT category.title, parent_id
    FROM categories AS category
    ORDER BY category.lft;