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
 
    $tutorial = $this->tutorialModel->where('url_presentation', $slug)->first();

    if ($tutorial) {
        $details = (new \App\Models\TutorialDetailModel())
                    ->where('tutorial_id', $tutorial['id'])
                    ->where('status', 'show') 
                    ->findAll();

        return view('view/presentation', [
            'tutorial' => $tutorial,
            'details'  => $details,
        ]);
    }


    return redirect()->to('/tutorial');
    }

    public function finished($slug) {

    $tutorial = $this->tutorialModel->where('url_finished', $slug)->first();


    if ($tutorial) {
        $details = (new \App\Models\TutorialDetailModel())
                    ->where('tutorial_id', $tutorial['id'])
                    ->findAll();

        return view('view/finished', [
            'tutorial' => $tutorial,
            'details'  => $details,
        ]);
    }

    
    return redirect()->to('/tutorial');
    }


}
