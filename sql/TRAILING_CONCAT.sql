SELECT
    is_id AS 'id', 
    CONCAT('URL?param=',it_id) AS 'pageUrl',
    TRIM(TRAILING ',' FROM CONCAT_WS(',',is_image0,is_image1,is_image2,is_image3,is_image4)) AS 'image',
    date_format(is_time, '%Y') yyyy,
    date_format(is_time, '%m') mm,
    date_format(is_time, '%d') dd,
    is_time AS 'registerDate',
    is_time AS 'modifyDate'
FROM 
    DB_TABLE
