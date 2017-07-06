<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Map extends CI_Controller
{
    private $def_lat;
    private $def_lng;

    public function __construct()
    {
        parent::__construct();
        //map config
        $this->load->helper(array('form', 'url'));
        $this->load->config('map');
        $this->def_lat = $this->config->item('default_lat');
        $this->def_lng = $this->config->item('default_lng');
        $this->load->library('googlemaps');
    }

    public function index()
    {
        $this->load->library('googlemaps');

        $config['center']                      = '37.4419, -122.1419';
        $config['zoom']                        = 'auto';
        $config['places']                      = true;
        $config['placesAutocompleteInputID']   = 'myPlaceTextBox';
        $config['placesAutocompleteBoundsMap'] = true; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange']  = 'alert(\'You selected a place\');';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();

        $this->load->view('v_map', $data);
    }
}
