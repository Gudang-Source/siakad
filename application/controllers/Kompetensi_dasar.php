<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Kompetensi_dasar extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kompetensi_dasar_model');
    } 

    /*
     * Listing of kompetensi_dasar
     */
    function index()
    {
        $data['kompetensi_dasar'] = $this->Kompetensi_dasar_model->get_all_kompetensi_dasar();
        $data['mapel'] = $this->Kompetensi_dasar_model->get_mapel();
        
        $data['_view'] = 'kompetensi_dasar/index';
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('kompetensi_dasar/index',$data);
        $this->load->view('template/footer');
    }

    /*
     * Adding a new kompetensi_dasar
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('id_mapel','Id Mapel','required');
		$this->form_validation->set_rules('id_kelas','Id Kelas','required');
		$this->form_validation->set_rules('kd','Kd','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'id_tahun' => $_SESSION['id_tahun_pelajaran'],
				'id_mapel' => $this->input->post('id_mapel'),
				'id_kelas' => $this->input->post('id_kelas'),
				'id_guru' => user_info()['id_guru'],
				'kd' => $this->input->post('kd'),
            );
            
            $kompetensi_dasar_id = $this->Kompetensi_dasar_model->add_kompetensi_dasar($params);
            redirect('kompetensi_dasar/index');
        }
        else
        {
			$this->load->model('Mapel_model');
			$data['all_mapel'] = $this->Mapel_model->get_all_mapel();

            $this->load->model('Kelas_model');
			$data['all_kelas'] = $this->Kelas_model->get_all_kelas();
            
            $data['_view'] = 'kompetensi_dasar/add';
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('kompetensi_dasar/add',$data);
            $this->load->view('template/footer');
        }
    }  

    /*
     * Editing a kompetensi_dasar
     */
    function edit($id)
    {   
        // check if the kompetensi_dasar exists before trying to edit it
        $data['kompetensi_dasar'] = $this->Kompetensi_dasar_model->get_kompetensi_dasar($id);
        
        if(isset($data['kompetensi_dasar']['id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('id_mapel','Id Mapel','required');
			$this->form_validation->set_rules('id_kelas','Id Kelas','required');
			$this->form_validation->set_rules('kd','Kd','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'id_tahun' => $this->input->post('id_tahun'),
					'id_mapel' => $this->input->post('id_mapel'),
					'id_kelas' => $this->input->post('id_kelas'),
					'id_guru' => $this->input->post('id_guru'),
					'kd' => $this->input->post('kd'),
                );

                $this->Kompetensi_dasar_model->update_kompetensi_dasar($id,$params);            
                redirect('kompetensi_dasar/index');
            }
            else
            {
				$this->load->model('Mapel_model');
				$data['all_mapel'] = $this->Mapel_model->get_all_mapel();

				$this->load->model('Kelas_model');
				$data['all_kelas'] = $this->Kelas_model->get_all_kelas();

                $data['_view'] = 'kompetensi_dasar/edit';
                $this->load->view('template/header');
                $this->load->view('template/sidebar');
                $this->load->view('kompetensi_dasar/edit',$data);
                $this->load->view('template/footer');
            }
        }
        else
            show_error('The kompetensi_dasar you are trying to edit does not exist.');
    } 

    /*
     * Deleting kompetensi_dasar
     */
    function remove($id)
    {
        $kompetensi_dasar = $this->Kompetensi_dasar_model->get_kompetensi_dasar($id);

        // check if the kompetensi_dasar exists before trying to delete it
        if(isset($kompetensi_dasar['id']))
        {
            $this->Kompetensi_dasar_model->delete_kompetensi_dasar($id);
            redirect('kompetensi_dasar/index');
        }
        else
            show_error('The kompetensi_dasar you are trying to delete does not exist.');
    }
    
}