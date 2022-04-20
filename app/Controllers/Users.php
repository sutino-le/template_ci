<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLevels;
use App\Models\ModelUsers;
use App\Models\ModelUsersPagination;
use Config\Services;

class Users extends BaseController
{
    public function __construct()
    {
        $this->levels   = new ModelLevels();
        $this->users    = new ModelUsers();
    }


    public function index()
    {
        $data = [
            'judul'         => 'Home',
            'subjudul'      => 'users',
        ];
        return view('users/viewdata', $data);
    }


    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelUsersPagination($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"edit('" . $list->userid . "')\" title=\"Edit\"><i class='fas fa-edit'></i></button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->userid . "')\" title=\"Hapus\"><i class='fas fa-trash-alt'></i></button>";

                $row[] = $no;
                $row[] = $list->userid;
                $row[] = $list->usernama;
                $row[] = $list->useremail;
                $row[] = $list->userpassword;
                $row[] = $list->userlevelid;
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

        $data = [
            'datalevel' => $this->levels->findAll()
        ];

        $json = [
            'data' => view('users/modaltambah', $data)
        ];

        echo json_encode($json);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $userid      = $this->request->getPost('userid');
            $usernama      = $this->request->getPost('usernama');
            $useremail      = $this->request->getPost('useremail');
            $userpassword      = $this->request->getPost('userpassword');
            $userlevelid      = $this->request->getPost('userlevelid');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'User ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'User Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useremail' => [
                    'rules'     => 'required',
                    'label'     => 'User Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword' => [
                    'rules'     => 'required',
                    'label'     => 'User Password',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userlevelid' => [
                    'rules'     => 'required',
                    'label'     => 'User Level',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'errUserID'         => $validation->getError('userid'),
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserEmail'      => $validation->getError('useremail'),
                        'errUserPassword'   => $validation->getError('userpassword'),
                        'errUserLevelId'    => $validation->getError('userlevelid'),
                    ]
                ];
            } else {
                $modelLevel = new Modelusers();

                $modelLevel->insert([
                    'userid'         => $userid,
                    'usernama'       => $usernama,
                    'useremail'      => $useremail,
                    'userpassword'   => $userpassword,
                    'userlevelid'    => $userlevelid
                ]);

                $json = [
                    'sukses'        => 'Data berhasil disimpan'
                ];
            }


            echo json_encode($json);
        }
    }


    public function formedit($userid)
    {

        $cekData        = $this->users->find($userid);
        if ($cekData) {
            $data = [
                'userid'        => $cekData['userid'],
                'usernama'      => $cekData['usernama'],
                'useremail'     => $cekData['useremail'],
                'userpassword'  => $cekData['userpassword'],
                'userlevelid'   => $cekData['userlevelid']
            ];

            $json = [
                'data' => view('users/modaledit', $data)
            ];
        }
        echo json_encode($json);
    }


    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $useridlama     = $this->request->getPost('useridlama');
            $userid         = $this->request->getPost('userid');
            $usernama       = $this->request->getPost('usernama');
            $useremail      = $this->request->getPost('useremail');
            $userpassword   = $this->request->getPost('userpassword');
            $userlevelid    = $this->request->getPost('userlevelid');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'userid' => [
                    'rules'     => 'required',
                    'label'     => 'User ID',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'usernama' => [
                    'rules'     => 'required',
                    'label'     => 'User Nama',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'useremail' => [
                    'rules'     => 'required',
                    'label'     => 'User Email',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userpassword' => [
                    'rules'     => 'required',
                    'label'     => 'User Password',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ],
                'userlevelid' => [
                    'rules'     => 'required',
                    'label'     => 'User Level',
                    'errors'    => [
                        'required'  => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $json = [
                    'error' => [
                        'erruserid'         => $validation->getError('userid'),
                        'errUserNama'       => $validation->getError('usernama'),
                        'errUserEmail'      => $validation->getError('useremail'),
                        'errUserPassword'   => $validation->getError('userpassword'),
                        'errUserLevelId'    => $validation->getError('userlevelid')
                    ]
                ];
            } else {

                $this->users->update($useridlama, [
                    'userid'           => $userid,
                    'usernama'         => $usernama,
                    'useremail'        => $useremail,
                    'userpassword'     => $userpassword,
                    'userlevelid'      => $userlevelid,
                ]);

                $json = [
                    'sukses'        => 'Data berhasil dirubah'
                ];
            }


            echo json_encode($json);
        }
    }

    public function hapus($userid)
    {
        $this->users->delete($userid);

        $json = [
            'sukses' => 'Data berhasil dihapus'
        ];


        echo json_encode($json);
    }
}
