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
