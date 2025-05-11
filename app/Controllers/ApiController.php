<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TutorialMasterModel;
use CodeIgniter\API\ResponseTrait;

class ApiController extends BaseController
{
    use ResponseTrait;

    public function getByMatkul($kode_matkul)
    {
        $model = new TutorialMasterModel();
        $tutorials = $model->where('kode_matkul', $kode_matkul)->findAll();

        if (empty($tutorials)) {
            return $this->respond([
                'status' => [
                    'code' => 404,
                    'description' => "Data tutorial untuk kode matkul $kode_matkul tidak ditemukan."
                ],
                'data' => []
            ], 404);
        }

        $nama_matkul = $tutorials[0]['nama_matkul'] ?? $kode_matkul;

        $data = array_map(function ($item) use ($kode_matkul, $nama_matkul) {
            return [
                'kdmk'             => $kode_matkul,
                'nama'             => $nama_matkul,
                'judul'            => $item['judul'],
                'url_presentation' => base_url('presentation/' . $item['url_presentation']),
                'url_finished'     => base_url('finished/' . $item['url_finished']),
                'creator_email'    => $item['creator_email'],
                'created_at'       => $item['created_at'],
                'updated_at'       => $item['updated_at'],
            ];
        }, $tutorials);

        return $this->respond([
            'status' => [
                'code' => 200,
                'description' => "OK"
            ],
            'data' => $data
        ]);
    }
}
