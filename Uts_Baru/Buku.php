<?php

class Buku {
    private $dataBuku;

    public function __construct() {
        global $dataBuku;
        $this->dataBuku = $dataBuku;
    }

    public function getDaftarBuku() {
        return $this->dataBuku;
    }

    public function pinjamBuku($id) {
        foreach ($this->dataBuku as $key => $data) {
            if ($data['id'] == $id) {
                $this->dataBuku[$key]['status'] = "Dipinjam";
                break;
            }
        }
    }

    public function kembalikanBuku($id) {
        foreach ($this->dataBuku as $key => $data) {
            if ($data['id'] == $id) {
                $this->dataBuku[$key]['status'] = "Tersedia";
                break;
            }
        }
    }

    public function tambahBuku($judul, $penulis) {
        $idBaru = max(array_map(function ($data) { return $data['id']; }, $this->dataBuku)) + 1;
        $this->dataBuku[] = [
            "id" => $idBaru,
            "judul" => $judul,
            "penulis" => $penulis,
            "status" => "Tersedia"
        ];
    }

    // Tambahkan fungsi updateBuku($id, $judul, $penulis) untuk update data buku
}

