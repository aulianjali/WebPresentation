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


        if ($response && isset($response['refreshToken'])) {
            session()->set('refreshToken', $response['refreshToken']);
            session()->set('user_email', $email);  
            session()->set('isLoggedIn', true);
            
            return redirect()->to('/tutorial');
        }

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Username atau Password Salah');
    }
}


    public function logout()
    {
        $refreshToken = session()->get('refreshToken');

        if ($refreshToken) {
            $response = WebserviceHelper::logout($refreshToken);

            if (isset($response['message'])) {
                $message = $response['message']; 
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
