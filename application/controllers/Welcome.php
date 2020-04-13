<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('inicio2.html');
		$this->load->model('Model');
		echo json_encode($this->Model->GetProducts());


	
	}

	function GetProucts(){
			if ($db->simpleQuery('SELECT SQL_CALC_FOUND_ROWS p.`id_product`  AS `id_product`,
			p.`reference`  AS `reference`,
			sa.`price`  AS `price`,
			p.`id_shop_default`  AS `id_shop_default`,
			p.`is_virtual`  AS `is_virtual`,
			pl.`name`  AS `name`,
			pl.`link_rewrite`  AS `link_rewrite`,
			sa.`active`  AS `active`,
			shop.`name`  AS `shopname`,
			image_shop.`id_image`  AS `id_image`,
			cl.`name`  AS `name_category`,
			0 AS `price_final`,
			pd.`nb_downloadable`  AS `nb_downloadable`,
			sav.`quantity`  AS `sav_quantity`,
			IF(sav.`quantity`<=0, 1, 0) AS `badge_danger` 
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
			
		   ORDER BY  `id_product` desc
			
		   LIMIT 0, 20
		   ;'))
	{
			echo "Success!";
	}
	else
	{
			echo "Query failed!";
	}
	}
	
	function GetAllcategories(){
		//categorias
		$api_url = "https://ADAE4VEJXZK2K14SHBVUUQ9LPFKCUZWU@mundopack.cl/api/categories/?display=full&output_format=JSON";
		$categorias =	$this->GetJsonUrlCategories($api_url, "name");
		 print_r($categorias);
		$api_url = "https://ADAE4VEJXZK2K14SHBVUUQ9LPFKCUZWU@mundopack.cl/api/products/?display=full&output_format=JSON";
		$Productos = $this->GetJsonUrl($api_url, 'name');
		// print_r($Productos);
		$ArrayConcatenaDescripcion = array();
		foreach($Productos as $prod){
		foreach($categorias as $cat){
		if($cat['id'] == $prod['categories']){
print_r($cat);
			// array_push($ArrayConcatenaDescripcion, array('id' =>$prod['id'], 'name' => $prod['name'], $cat['categories'] ));
		}
		}
	}
		print_r($ArrayConcatenaDescripcion);
	}
	
		  
		
	function GetJsonUrl($url, $value){  
		$data = json_decode(file_get_contents($url), true);
		$max = 0;
		foreach($data as $dat){
			$max = count($dat) - 1;
		}
		$a = array();
		foreach($data as $datas){
		for( $i=2; $i<=$max; $i++ ){
		array_push($a, array('id' => $datas[$i]['id'], 'name' =>$datas[$i][$value], 'categories' => $datas[$i]['id_category_default']));
			}
		}
		return $a;
	} 

	function GetJsonUrlCategories($url, $value){  
		$data = json_decode(file_get_contents($url), true);
		$max = 0;
		foreach($data as $dat){
			$max = count($dat) - 1;
		}
		$a = array();
		foreach($data as $datas){
		for( $i=2; $i<=$max; $i++ ){
		array_push($a, array('id' => $datas[$i]['id'], 'name' =>$datas[$i][$value]));
			}
		}
		return $a;
	} 
	function Getall(){
//get productos
	$url_products = "https://ADAE4VEJXZK2K14SHBVUUQ9LPFKCUZWU@mundopack.cl/api/products/?display=full&output_format=JSON";
	$products = json_decode(file_get_contents($url_products), true);
	$url_categories = "https://ADAE4VEJXZK2K14SHBVUUQ9LPFKCUZWU@mundopack.cl/api/categories/?display=full&output_format=JSON";
	$categories = json_decode(file_get_contents($url_categories), true);

		$max = 0;
		
		$categoriasFull = array();
		$productosFull = array();
		$full = array();
		foreach($categories as $cat){
			foreach($products as $prod){
				
					$max = count($cat) - 1;
					for( $i=2; $i<=$max; $i++ ){
							array_push($categoriasFull, array('idcategoria'=> $cat[$i]['id'], 'name' => $cat[$i]['name']));
					
					}

					$max2 = count($prod) - 1;
					for( $i=2; $i<=$max2; $i++ ){
							array_push($productosFull, array('idproducto'=> $prod[$i]['id'], 'name' => $prod[$i]['name'], 'idcatprod' => $prod[$i]['id_category_default']));
					}

				

			}
		}

		$var = array_merge($productosFull, $categoriasFull);

	
		echo json_encode($var);
	
		// print_r($ProductosFull);
	}
	
}
