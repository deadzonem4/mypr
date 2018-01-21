<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Controller to handle the homepage of the portal
 * @author: Rosen Georgiev
 **/
class Home extends CI_Controller {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Display the default home page
     */
    public function index() {
        $data['title'] = 'News | Lab';
        $this->load->model('post_model', 'news');
        if(!is_logged_in()) {
            $data['news'] = $this->news->get_posts(10);
            $this->template->view('home/public', $data);
        } else {
            $data['news'] = $this->news->get_all();
            $this->template->view('home/member', $data);
        }
    }
}