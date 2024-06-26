<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Period_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    // Get period from database
    function get($params = array())
    {
        if (isset($params['period_id'])) {
            $this->db->where('id', $params['period_id']);
        }

        if (isset($params['status'])) {
            $this->db->where('period_status', $params['status']);
        }

        if (isset($params['period_start'])) {
            $this->db->where('period_start', $params['period_start']);
        }
        if (isset($params['period_end'])) {
            $this->db->where('period_end', $params['period_end']);
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'asc');
        } else {
            $this->db->order_by('id', 'asc');
        }
        $this->db->where('period_status', '1');
        $this->db->select('id, period_start, period_end, period_status');
        $res = $this->db->get('period');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Add and update to database
    function add($data = array())
    {

        if (isset($data['period_id'])) {
            $this->db->set('id', $data['period_id']);
        }

        if (isset($data['period_start'])) {
            $this->db->set('period_start', $data['period_start']);
        }

        if (isset($data['period_end'])) {
            $this->db->set('period_end', $data['period_end']);
        }

        if (isset($data['period_status'])) {
            $this->db->set('period_status', $data['period_status']);
        }

        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('period');
            $id = $data['id'];
        } else if (isset($data['status_active'])) {
            $this->db->update('period');
            $id = NULL;
        } else {
            $this->db->insert('period');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
}
