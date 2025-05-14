<?php

namespace App\Controllers;

use App\Models\TutorialMasterModel;
use App\Models\TutorialDetailModel;


class TutorialMasterController extends BaseController
{
    protected $session;
    protected $tutorialModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->tutorialModel = new TutorialMasterModel();

        if (!$this->session->get('isLoggedIn')) {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $data['tutorials'] = $this->tutorialModel->findAll();
        $data['success'] = $this->session->getFlashdata('success');
        return view('tutorial/index', $data);
    }

    public function create()
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', 'https://jwt-auth-eight-neon.vercel.app/getMakul', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->session->get('refreshToken')
            ]
        ]);
        
        $dataMakul = json_decode($response->getBody(), true);
        $data['matkuls'] = is_array($dataMakul) && isset($dataMakul['data']) ? $dataMakul['data'] : [];

        return view('tutorial/create', $data);
    }

    public function save() {
    $judul = $this->request->getPost('judul');
    $kode_matkul = $this->request->getPost('kode_matkul');
    $creator_email = $this->session->get('user_email');

    $unique_code_presentation = uniqid();
    $unique_code_finished = uniqid();

    $url_presentation = strtolower(url_title($judul . '-' . $kode_matkul)) . '-' . $unique_code_presentation;
    $url_finished = strtolower(url_title($judul . '-' . $kode_matkul)) . '-' . $unique_code_finished;

    $data = [
        'judul'            => $judul,
        'kode_matkul'      => $kode_matkul,
        'url_presentation' => $url_presentation,
        'url_finished'     => $url_finished,
        'creator_email'    => $creator_email,
        'created_at'       => date('Y-m-d H:i:s'),
        'updated_at'       => date('Y-m-d H:i:s'),
    ];

    $this->tutorialModel->save($data);
    $this->session->setFlashdata('success', 'Tutorial berhasil ditambahkan.');
    return redirect()->to('/tutorial');
}


    public function edit($id)
    {
        $data['tutorial'] = $this->tutorialModel->find($id);
        return view('tutorial/edit', $data);
    }

   public function update($id) {
    $this->tutorialModel->update($id, [
        'kode_matkul'      => $this->request->getPost('kode_matkul'),
        'judul'            => $this->request->getPost('judul'),
        'url_presentation' => $this->request->getPost('url_presentation'),
        'url_finished'     => $this->request->getPost('url_finished'),
        'updated_at'       => date('Y-m-d H:i:s'),
    ]);

    // Simpan detail tutorial (jika ada)
    $text         = $this->request->getPost('text');
    $order        = $this->request->getPost('order');
    $status       = $this->request->getPost('status');
    $url_optional = $this->request->getPost('url_optional');
    $code         = $this->request->getPost('code');

    $imageFile = $this->request->getFile('image');
    $imageName = null;

    if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
        $imageName = $imageFile->getRandomName();
        $imageFile->move(ROOTPATH . 'public/uploads', $imageName);
    }

    if (!empty($text) || !empty($code) || $imageName) {
        $detailModel = new TutorialDetailModel();
        $existingDetail = $detailModel->where('tutorial_id', $id)->first();
        if ($existingDetail) {
            $detailModel->update($existingDetail['id'], [
                'text'        => $text,
                'order'       => $order,
                'status'      => $status,
                'url'         => $url_optional,
                'image'       => $imageName,
                'code'        => $code,
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
        } else {
            $detailModel->save([
                'tutorial_id' => $id,
                'text'        => $text,
                'order'       => $order,
                'status'      => $status,
                'url'         => $url_optional,
                'image'       => $imageName,
                'code'        => $code,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }
    }

    return redirect()->to('/tutorial');
    }



    public function delete($id)
    {
        $this->tutorialModel->delete($id);
        return redirect()->to('/tutorial');
    }
}
