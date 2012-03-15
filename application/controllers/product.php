<?php



/**
 * Description of product
 *
 * @author Utilizador
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends SIGMA_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('products_model', 'products');
    }
    
    function index() {
        $prod = $this->products->getProducts();
        $this->menu = $this->products->getCategories();

        $data = array('pages' => $this->menu ? $this->menu : array());

        $this->template->write_view('header', 'header', $data);
        $this->template->write_view('top', 'modules/auth');
        $this->template->write_view('sidebar', 'modules/navigation', $data);

        $data = array('prods' => $prod ? $prod : array());
        $this->template->write_view('content', 'modules/shop/list', $data);
        $this->template->write_view('footer', 'footer');
        $this->template->render();
    }
    
    public function id($id = '') {
        $prod = $this->products->getProducts(!empty($id) ? $id : null);
        $this->menu = $this->products->getCategories($id ? $id : null);

        $data = array('pages' => $this->menu ? $this->menu : array());

        $this->template->write_view('header', 'header', $data);
        $this->template->write_view('top', 'modules/auth');
        $this->template->write_view('sidebar', 'modules/navigation', $data);

        $data = array('prod' => $prod ? $prod : array());
        $this->template->write_view('content', 'modules/shop/product', $data);
        $this->template->write_view('footer', 'footer');
        $this->template->render();
    }
    
    function listing() {
        $prod = $this->products->getProducts();
        $this->menu = $this->products->getCategories();

        $data = array('pages' => $this->menu ? $this->menu : array());

        $this->template->write_view('header', 'header', $data);
        $this->template->write_view('top', 'modules/auth');
        $this->template->write_view('sidebar', 'modules/navigation', $data);

        $data = array('prods' => $prod ? $prod : array());
        $this->template->write_view('content', 'modules/shop/list', $data);
        $this->template->write_view('footer', 'footer');
        $this->template->render();
    }
}

?>