<?php

namespace App\Controllers;

use App\Helpers\WebserviceHelper;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
{
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    try {
        $response = WebserviceHelper::login($email, $password);

        // Jika login berhasil dan mendapatkan refreshToken
        if ($response && isset($response['refreshToken'])) {
            // Set session dengan refreshToken dan user_email
            session()->set('refreshToken', $response['refreshToken']);
            session()->set('user_email', $email);  
            session()->set('isLoggedIn', true);
            
            // Redirection ke halaman tutorial setelah login berhasil
            return redirect()->to('/tutorial');
        }

    } catch (\Exception $e) {
        // Tangani exception jika ada kesalahan dalam memanggil webservice
        return redirect()->back()->with('error', 'Username atau Password Salah');
    }
}


    public function logout()
    {
        $refreshToken = session()->get('refreshToken');
        //$message      = 'Logout berhasil.'; // Default kalau gak ada response

        if ($refreshToken) {
            $response = WebserviceHelper::logout($refreshToken);

            if (isset($response['message'])) {
                $message = $response['message']; // ambil 'OK' atau pesan lain
            }
        }

        session()->destroy();

        return redirect()->to('/login')
            ->with('success', $message)
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma'        => 'no-cache',
                'Expires'       => '0',
            ]);
    }
}
