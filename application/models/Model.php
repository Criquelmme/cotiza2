<?php
class Model extends CI_Model{

    public function GetProducts(){
        $db['default']['db_debug'] = FALSE;

        $query="SELECT SQL_CALC_FOUND_ROWS p.`id_product`  AS `id_product`,
        pl.`name`  AS `name`,
        pl.description,
        image_shop.`id_image`  AS `id_image`,
        cl.`name`  AS `name_category`
       FROM  `ps6d_product` p 
        LEFT JOIN `ps6d_product_lang` pl ON (pl.`id_product` = p.`id_product` AND pl.`id_lang` = 2 AND pl.`id_shop` = 1) 
        LEFT JOIN `ps6d_stock_available` sav ON (sav.`id_product` = p.`id_product` AND sav.`id_product_attribute` = 0 AND sav.id_shop = 1  AND sav.id_shop_group = 0 ) 
        JOIN `ps6d_product_shop` sa ON (p.`id_product` = sa.`id_product` AND sa.id_shop = 1) 
        LEFT JOIN `ps6d_category_lang` cl ON (sa.`id_category_default` = cl.`id_category` AND cl.`id_lang` = 2 AND cl.id_shop = 1) 
        LEFT JOIN `ps6d_category` c ON (c.`id_category` = cl.`id_category`) 
        LEFT JOIN `ps6d_shop` shop ON (shop.id_shop = 1) 
        LEFT JOIN `ps6d_image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.`cover` = 1 AND image_shop.id_shop = 1) 
        LEFT JOIN `ps6d_image` i ON (i.`id_image` = image_shop.`id_image`) 
        LEFT JOIN `ps6d_product_download` pd ON (pd.`id_product` = p.`id_product`) 
       WHERE (1 AND state = 1)
        
       ORDER BY  `id_product` desc";
        $resultados = $this->db->query($query);
        return $resultados->result();
    }
}