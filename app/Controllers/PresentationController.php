<?php

namespace App\Controllers;

use App\Models\TutorialMasterModel;

class PresentationController extends BaseController
{
    protected $tutorialModel;

    public function __construct() {
        $this->tutorialModel = new TutorialMasterModel();
    }

   public function show($slug) {
    // Mencari tutorial berdasarkan URL presentation
    $tutorial = $this->tutorialModel->where('url_presentation', $slug)->first();

    // Jika tutorial ditemukan
    if ($tutorial) {
        // Mengambil detail tutorial berdasarkan tutorial_id
        $details = (new \App\Models\TutorialDetailModel())
                    ->where('tutorial_id', $tutorial['id'])
                    ->where('status', 'show') // Menampilkan hanya detail dengan status 'show'
                    ->findAll();

        return view('view/presentation', [
            'tutorial' => $tutorial,
            'details'  => $details,
        ]);
    }

    // Jika tidak ada, redirect ke tutorial list
    return redirect()->to('/tutorial');
    }

    public function finished($slug) {
    // Mencari tutorial berdasarkan URL finished
    $tutorial = $this->tutorialModel->where('url_finished', $slug)->first();

    // Jika tutorial ditemukan
    if ($tutorial) {
        // Mengambil detail tutorial berdasarkan tutorial_id
        $details = (new \App\Models\TutorialDetailModel())
                    ->where('tutorial_id', $tutorial['id'])
                    ->findAll();

        return view('view/finished', [
            'tutorial' => $tutorial,
            'details'  => $details,
        ]);
    }

    // Jika tidak ada, redirect ke tutorial list
    return redirect()->to('/tutorial');
    }


}
