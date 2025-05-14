<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TutorialMasterModel;
use App\Models\TutorialDetailModel;

class TutorialDetailController extends BaseController
{
    protected $tutorialMasterModel;
    protected $tutorialDetailModel;

    public function __construct()
    {
        $this->tutorialMasterModel = new TutorialMasterModel();
        $this->tutorialDetailModel = new TutorialDetailModel();
    }


    public function index($tutorialId)
    {
        $tutorial = $this->tutorialMasterModel->find($tutorialId);
        if (!$tutorial) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tutorial tidak ditemukan');
        }

        $details = $this->tutorialDetailModel
            ->where('tutorial_id', $tutorialId)
            ->orderBy('tutor_order', 'ASC')
            ->findAll();

        return view('tutorial/detail', [
            'tutorial' => $tutorial,
            'details'  => $details
        ]);
    }


    public function create($tutorialId, $detailId = null)
    {
        $tutorial = $this->tutorialMasterModel->find($tutorialId);
        if (!$tutorial) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Tutorial tidak ditemukan');
        }

        $detail = null;
        if ($detailId) {
            $detail = $this->tutorialDetailModel->find($detailId);
            if (!$detail) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Detail tutorial tidak ditemukan');
            }
        }

        return view('tutorial/create_detail', [
            'tutorial' => $tutorial,
            'detail'   => $detail
        ]);
    }


   public function store($tutorialId) {
    $text  = $this->request->getPost('text');
    $code  = $this->request->getPost('code');
    $url   = $this->request->getPost('url');
    $image = $this->request->getFile('image');


    if (empty($text) && empty($code) && empty($url) && (!$image || !$image->isValid())) {
        return redirect()->back()->withInput()->with('errors', [
            'content' => 'Minimal isi salah satu dari Text, Code, URL, atau Image.'
        ]);
    }

    $rules = [
        'tutor_order' => 'required|integer',
        'status'      => 'required|in_list[show,hide]',
        'url'         => 'permit_empty|valid_url',
        'image'       => 'permit_empty|is_image[image]',
        'code'        => 'permit_empty',
        'text'        => 'permit_empty',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $order = (int) $this->request->getPost('tutor_order');


    $this->tutorialDetailModel
        ->where('tutorial_id', $tutorialId)
        ->where('tutor_order >=', $order)
        ->set('tutor_order', 'tutor_order + 1', false)
        ->update();

    $data = [
        'tutorial_id' => $tutorialId,
        'text'        => $text,
        'tutor_order' => $order,
        'status'      => $this->request->getPost('status'),
        'url'         => $url,
        'code'        => $code,
    ];

    if ($image && $image->isValid() && !$image->hasMoved()) {
        $newName = $image->getRandomName();
        $image->move('uploads/images/', $newName);
        $data['image'] = $newName;
    }

    $this->tutorialDetailModel->insert($data);

    return redirect()->to('/tutorial/' . $tutorialId . '/detail')
                     ->with('success', 'Detail tutorial berhasil ditambahkan');
    }


   public function update($tutorialId, $detailId) {
    $text  = $this->request->getPost('text');
    $code  = $this->request->getPost('code');
    $url   = $this->request->getPost('url');
    $image = $this->request->getFile('image');


    if (empty($text) && empty($code) && empty($url) && (!$image || !$image->isValid())) {
        return redirect()->back()->withInput()->with('errors', [
            'content' => 'Minimal isi salah satu dari Text, Code, URL, atau Image.'
        ]);
    }

    $rules = [
        'tutor_order' => 'required|integer',
        'status'      => 'required|in_list[show,hide]',
        'url'         => 'permit_empty|valid_url',
        'image'       => 'permit_empty|is_image[image]',
        'code'        => 'permit_empty',
        'text'        => 'permit_empty',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $existing = $this->tutorialDetailModel->find($detailId);
    $newOrder = (int) $this->request->getPost('tutor_order');
    $oldOrder = $existing['tutor_order'];

    if ($newOrder != $oldOrder) {
        if ($newOrder > $oldOrder) {
            $this->tutorialDetailModel
                ->where('tutorial_id', $tutorialId)
                ->where('tutor_order >', $oldOrder)
                ->where('tutor_order <=', $newOrder)
                ->set('tutor_order', 'tutor_order - 1', false)
                ->update();
        } else {
            $this->tutorialDetailModel
                ->where('tutorial_id', $tutorialId)
                ->where('tutor_order >=', $newOrder)
                ->where('tutor_order <', $oldOrder)
                ->set('tutor_order', 'tutor_order + 1', false)
                ->update();
        }
    }

    $data = [
        'id'          => $detailId,
        'tutorial_id' => $tutorialId,
        'text'        => $text,
        'tutor_order' => $newOrder,
        'status'      => $this->request->getPost('status'),
        'url'         => $url,
        'code'        => $code,
    ];

    if ($image && $image->isValid() && !$image->hasMoved()) {
        $newName = $image->getRandomName();
        $image->move('uploads/images/', $newName);
        $data['image'] = $newName;
    }

    $this->tutorialDetailModel->save($data);

    return redirect()->to('/tutorial/' . $tutorialId . '/detail')
                     ->with('success', 'Detail tutorial berhasil diperbarui');
    }


    public function delete($tutorialId, $detailId)
    {
        $detail = $this->tutorialDetailModel->find($detailId);
        if (!$detail || $detail['tutorial_id'] != $tutorialId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Detail tidak ditemukan');
        }

        if (!empty($detail['image']) && file_exists('uploads/images/' . $detail['image'])) {
            unlink('uploads/images/' . $detail['image']);
        }

        $this->tutorialDetailModel->delete($detailId);

        return redirect()->to('/tutorial/' . $tutorialId . '/detail')
                         ->with('success', 'Detail tutorial berhasil dihapus');
    }

    public function toggleStatus($tutorialId, $detailId)
{
    $detail = $this->tutorialDetailModel->find($detailId);

   
    if (!$detail || $detail['tutorial_id'] != $tutorialId) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

  
    $newStatus = $detail['status'] === 'show' ? 'hide' : 'show';


    $updated = $this->tutorialDetailModel->update($detailId, [
        'status' => $newStatus
    ]);

    if (!$updated) {
        return redirect()->back()->with('error', 'Gagal mengubah status.');
    }

    
    return redirect()->to("/tutorial/{$tutorialId}/detail");
}


}
