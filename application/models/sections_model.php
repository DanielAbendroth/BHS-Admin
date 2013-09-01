<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class controls the access to the Sections database
 */
class Sections_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('date');
	}
	
	public function create_section($data)
	{
		$data['date_created'] = date('Y-m-d');
		$data['created_by']	= $this->session->userdata('id');
		
		return $this->db->insert('sections',$data);
		
	}
	
	public function get_options($id)
	{
		$data['id'] = $id;
		$this->db->select('options');
		$data = $this->db->get_where('sections',$data,1);
		foreach ($data as $row) {
			$options = unserialize($row);
		}
		return $options;
	}

	public function add_field($data)
	{
		$options = array();
		$id = $this->uri->segment(5);
		$this->db->select('options');
		$query = $this->db->get_where('sections',array('id' => $id),1);
		foreach ($query->result() as $row) {
			if($row->options != '') {
				$options = unserialize($row->options);
			}
			$options[] = $data;
			$options = serialize($options);
			$update = array(
				'options' => $options
			);
			$this->db->where('id', $id);
			$this->db->update('sections',$update);
		}
	}

	public function get_field($section,$field=FALSE)
	{
		$this->db->select('options');
		$query = $this->db->get_where('sections',array('id'=>$section),1);
		foreach ($query->result() as $row) {
			$options = $row->options;
		}
		if(!is_numeric($field)) {
			return unserialize($options);
		} else {
			$options = unserialize($options);
			return $options[$field];
		}
	}

	public function update_field($data,$section,$field)
	{
		$options = $this->Sections_model->get_field($section);
		$options[$field] = $data;
		$data = array('options'=>serialize($options));
		
		$this->db->where('id',$section);
		$this->db->update('sections',$data);
	}

	public function get_section($section)
	{
		$this->db->where('id',$section);
		return $this->db->get('sections');
	}
}

/* End of file sections_model.php */
/* Location: ./application/models/sections_model.php */