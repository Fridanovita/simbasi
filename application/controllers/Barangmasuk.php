<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
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
        $data['title'] = "Barang Masuk";
        $data['barangmasuk'] = $this->admin->getBarangMasuk();
        $this->template->load('templates/dashboard', 'barang_masuk/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('serial_number[]', 'Serial Number', 'required'); // Validasi untuk serial number
        $this->form_validation->set_rules('merk[]', 'Merk', 'required'); // Validasi untuk kondisi
        $this->form_validation->set_rules('tipe[]', 'Tipe', 'required'); // Validasi untuk kondisi
        $this->form_validation->set_rules('kondisi[]', 'Kondisi', 'required'); // Validasi untuk kondisi
        $this->form_validation->set_rules('location[]', 'Location', 'required'); // Validasi untuk location
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->admin->get('barang');

            // Mendapatkan dan men-generate kode transaksi barang masuk
            $kode = 'T-BM-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_masuk', 'id_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_masuk'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_masuk/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $id_barang_masuk = $input['id_barang_masuk'];
            $tanggal_masuk = $input['tanggal_masuk'];
            $supplier_id = $input['supplier_id'];
            $barang_id = $input['barang_id']; // Barang ID diambil dari form
            $jumlah_masuk = $input['jumlah_masuk'];
            $user_id = $this->session->userdata('login_session')['user'];

            // Data untuk tabel barang_masuk
            $data_barang_masuk = [
                'id_barang_masuk' => $id_barang_masuk,
                'tanggal_masuk' => $tanggal_masuk,
                'supplier_id' => $supplier_id,
                'barang_id' => $barang_id, // Masukkan barang_id di sini
                'jumlah_masuk' => $jumlah_masuk,
                'user_id' => $user_id
            ];

            // Insert data ke tabel barang_masuk
            $insert = $this->admin->insert('barang_masuk', $data_barang_masuk);

            if ($insert) {
                // Ambil data detail barang
                $serial_number = $input['serial_number'];
                $merk = $input['merk'];
                $tipe = $input['tipe'];
                $kondisi = $input['kondisi'];
                $location = $input['location'];
            
                // Array untuk menyimpan data detail_barang
                $data_detail_barang = [];
            
                // Loop melalui data detail barang untuk menyimpannya ke tabel detail_barang
                for ($i = 0; $i < count($serial_number); $i++) {
                    // Mendapatkan dan men-generate kode detail barang
                    $kode_detail = 'D-BM-'; // Ubah kode detail barang sesuai kebutuhan
                    $kode_terakhir_detail = $this->admin->getMax('detail_barang', 'id_detail', $kode_detail);

                    // Debugging untuk memastikan nilai kode terakhir
                    echo "Kode terakhir detail: " . $kode_terakhir_detail . "<br>";

                    // Periksa apakah $kode_terakhir_detail memiliki nilai
                    if ($kode_terakhir_detail) {
                        $kode_tambah_detail = substr($kode_terakhir_detail, -5, 5);
                        $kode_tambah_detail = intval($kode_tambah_detail) + count($serial_number); // Menggunakan count($serial_number) untuk menambah sesuai jumlah barang masuk
                    } else {
                        $kode_tambah_detail = 1;
                    }

                    $number_detail = str_pad($kode_tambah_detail, 5, '0', STR_PAD_LEFT);
                    $id_detail = $kode_detail . $number_detail;

                    // Debugging untuk memastikan nilai id_detail
                    echo "ID Detail: " . $id_detail . "<br>";

                    $data_detail_barang[] = [
                        'id_detail' => $id_detail, // Tambahkan id_detail ke data detail_barang
                        'id_barang_masuk' => $id_barang_masuk,
                        'barang_id' => $barang_id, // Tambahkan barang_id ke data detail_barang
                        'serial_number' => $serial_number[$i],
                        'merk' => $merk[$i],
                        'tipe' => $tipe[$i],
                        'kondisi' => $kondisi[$i],
                        'location' => $location[$i]
                    ];
                }

                // Insert data detail_barang dalam bentuk batch
                $this->admin->insert('detail_barang', $data_detail_barang, true);

                set_pesan('data berhasil disimpan.');
                redirect('barangmasuk');
                } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangmasuk/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_masuk', 'id_barang_masuk', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangmasuk');
    }
}
