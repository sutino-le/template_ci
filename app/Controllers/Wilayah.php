<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWilayah;
use App\Models\ModelWilayahPagination;
use Config\Services;

class Wilayah extends BaseController
{
    public function __construct()
    {
        $this->wilayah = new ModelWilayah();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Wilayah',
        ];
        return view('wilayah/viewdata', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelWilayahPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->id_wilayah . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->id_wilayah . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->kelurahan;
                $row[] = $list->kecamatan;
                $row[] = $list->kota_kabupaten;
                $row[] = $list->propinsi;
                $row[] = $list->kodepos;
                $row[] = $tombolEdit . ' ' . $tombolHapus;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }


    public function formtambah()
    {
        $json = [
            'data' => view('wilayah/modaltambah')
        ];

        echo json_encode($json);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $kelurahan      = $this->request->getPost('kelurahan');
            $kecamatan      = $this->request->getPost('kecamatan');
            $kota_kabupaten = $this->request->getPost('kota_kabupaten');
            $propinsi       = $this->request->getPost('propinsi');
            $kodepos        = $this->request->getPost('kodepos');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kelurahan' => [
                    'rules'     => 'required',
                    'label'     => 'Kelurahan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kecamatan' => [
                    'rules'     => 'required',
                    'label'     => 'Kecamatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kota_kabupaten' => [
                    'rules'     => 'required',
                    'label'     => 'Kota / Kabupaten',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'propinsi' => [
                    'rules'     => 'required',
                    'label'     => 'Propinsi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kodepos' => [
                    'rules'     => 'required|numeric',
                    'label'     => 'Kodepos',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong',
                        'numeric'   => '{field} hanya dalam bentuk angka'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKelurahan'      => $validation->getError('kelurahan'),
                        'errKecamatan'      => $validation->getError('kecamatan'),
                        'errKotaKabupaten'  => $validation->getError('kota_kabupaten'),
                        'errPropinsi'       => $validation->getError('propinsi'),
                        'errKodepos'        => $validation->getError('kodepos'),
                    ]
                ];
            } else {
                $modelWilayah = new ModelWilayah();

                $modelWilayah->insert([
                    'kelurahan'         => $kelurahan,
                    'kecamatan'         => $kecamatan,
                    'kota_kabupaten'    => $kota_kabupaten,
                    'propinsi'          => $propinsi,
                    'kodepos'           => $kodepos,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($id_wilayah)
    {

        $cekData        = $this->wilayah->find($id_wilayah);
        if ($cekData) {
            $data = [
                'id_wilayah'        => $cekData['id_wilayah'],
                'kelurahan'         => $cekData['kelurahan'],
                'kecamatan'         => $cekData['kecamatan'],
                'kota_kabupaten'    => $cekData['kota_kabupaten'],
                'propinsi'          => $cekData['propinsi'],
                'kodepos'           => $cekData['kodepos'],
            ];

            $json = [
                'data' => view('wilayah/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $id_wilayah     = $this->request->getPost('id_wilayah');
            $kelurahan      = $this->request->getPost('kelurahan');
            $kecamatan      = $this->request->getPost('kecamatan');
            $kota_kabupaten = $this->request->getPost('kota_kabupaten');
            $propinsi       = $this->request->getPost('propinsi');
            $kodepos        = $this->request->getPost('kodepos');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'kelurahan' => [
                    'rules'     => 'required',
                    'label'     => 'Kelurahan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kecamatan' => [
                    'rules'     => 'required',
                    'label'     => 'Kecamatan',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kota_kabupaten' => [
                    'rules'     => 'required',
                    'label'     => 'Kota / Kabupaten',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'propinsi' => [
                    'rules'     => 'required',
                    'label'     => 'Propinsi',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'kodepos' => [
                    'rules'     => 'required|numeric',
                    'label'     => 'Kodepos',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong',
                        'numeric'   => '{field} hanya dalam bentuk angka'
                    ]
                ],
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errKelurahan'      => $validation->getError('kelurahan'),
                        'errKecamatan'      => $validation->getError('kecamatan'),
                        'errKotaKabupaten'  => $validation->getError('kota_kabupaten'),
                        'errPropinsi'       => $validation->getError('propinsi'),
                        'errKodepos'        => $validation->getError('kodepos'),
                    ]
                ];
            } else {

                $this->wilayah->update($id_wilayah, [
                    'kelurahan'         => $kelurahan,
                    'kecamatan'         => $kecamatan,
                    'kota_kabupaten'    => $kota_kabupaten,
                    'propinsi'          => $propinsi,
                    'kodepos'           => $kodepos,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapus($id_wilayah)
    {
        $this->wilayah->delete($id_wilayah);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
