<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLevels;
use App\Models\ModelLevelsPagination;
use Config\Services;

class Levels extends BaseController
{
    public function __construct()
    {
        $this->levels = new ModelLevels();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'Levels',
        ];
        return view('levels/viewdata', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelLevelsPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->levelid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->levelid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->levelid;
                $row[] = $list->levelnama;
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
            'data' => view('levels/modaltambah')
        ];

        echo json_encode($json);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $levelid      = $this->request->getPost('levelid');
            $levelnama      = $this->request->getPost('levelnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'levelid' => [
                    'rules'     => 'required|numeric',
                    'label'     => 'Level ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong',
                        'numeric'   => '{field} hanya angka'
                    ]
                ],
                'levelnama' => [
                    'rules'     => 'required',
                    'label'     => 'Level Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errLevelID'      => $validation->getError('levelid'),
                        'errLevelNama'      => $validation->getError('levelnama'),
                    ]
                ];
            } else {
                $modelLevel = new ModelLevels();

                $modelLevel->insert([
                    'levelid'         => $levelid,
                    'levelnama'         => $levelnama
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($levelid)
    {

        $cekData        = $this->levels->find($levelid);
        if ($cekData) {
            $data = [
                'levelid'        => $cekData['levelid'],
                'levelnama'         => $cekData['levelnama']
            ];

            $json = [
                'data' => view('levels/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $levelidlama     = $this->request->getPost('levelidlama');
            $levelid     = $this->request->getPost('levelid');
            $levelnama      = $this->request->getPost('levelnama');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'levelid' => [
                    'rules'     => 'required|numeric',
                    'label'     => 'Level ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong',
                        'numeric'   => '{field} hanya angka'
                    ]
                ],
                'levelnama' => [
                    'rules'     => 'required',
                    'label'     => 'Level Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errLevelID'      => $validation->getError('levelid'),
                        'errLevelNama'      => $validation->getError('levelnama')
                    ]
                ];
            } else {

                $this->levels->update($levelidlama, [
                    'levelid'           => $levelid,
                    'levelnama'         => $levelnama,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapus($levelid)
    {
        $this->levels->delete($levelid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
