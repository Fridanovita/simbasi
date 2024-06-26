<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Barang";
        $data['barang'] = $this->admin->getBarang();
        $this->template->load('templates/dashboard', 'barang/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jenis_id', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('satuan_id', 'Satuan Barang', 'required');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang";
            $data['jenis'] = $this->admin->get('jenis');
            $data['satuan'] = $this->admin->get('satuan');

            // Mengenerate ID Barang
            $kode_terakhir = $this->admin->getMax('barang', 'id_barang');
            $kode_tambah = substr($kode_terakhir, -6, 6);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            $data['id_barang'] = 'B' . $number;

            $this->template->load('templates/dashboard', 'barang/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('barang', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang";
            $data['jenis'] = $this->admin->get('jenis');
            $data['satuan'] = $this->admin->get('satuan');
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            $this->template->load('templates/dashboard', 'barang/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('barang', 'id_barang', $id, $input);

            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('barang');
            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang', 'id_barang', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->admin->cekStok($id);
        output_json($query);
    }

    public function detail($id_barang)
    {
    $data['title'] = "Detail Barang";
    $data['barang'] = $this->admin->get('barang', ['id_barang' => $id_barang]);
    $data['detail_barang'] = $this->admin->getDetailBarang($id_barang);

    if ($data['barang']) {
        $this->template->load('templates/dashboard', 'barang/view_detail', $data);
    } else {
        set_pesan('data tidak ditemukan', false);
        redirect('barang');
    }
    }

    public function edit_detail($id_detail)
    {
        $id = encode_php_tags($id_detail);
        $this->_validasi();
    
        if ($this->form_validation->run() == false) {
            $data['title'] = "Edit Detail Barang";
            $data['id_detail'] = $id_detail;
            $data['detail_barang'] = $this->admin->editDetailBarang($id_detail); // pastikan fungsi ini ada dan bekerja
            $this->template->load('templates/dashboard', 'barang/edit_detail', $data);
        } else {
            $input = $this->input->post(null, true);
            // Log data yang akan diupdate
            log_message('debug', 'Input data: ' . print_r($input, true));
            $update = $this->admin->update('detail_barang', 'id_detail', $id, $input);
    
            if ($update) {
                set_pesan('data detail berhasil disimpan');
                redirect('barang/detail'); // sesuaikan redirect sesuai kebutuhan
            } else {
                set_pesan('gagal menyimpan data detail');
                redirect('barang/edit_detail/' . $id_detail);
            }
        }
    }
    

    public function delete_detail($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('detail_barang', 'id_detail', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barang/detail');
    }
}
