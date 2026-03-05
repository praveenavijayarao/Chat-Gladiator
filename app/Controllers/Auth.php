<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function signup()
    {
        return view('auth/signup');
    }

    public function register()
    {
        $userModel = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $name = $this->request->getPost('name');

        // Check if email already exists
        if ($userModel->getUserByEmail($email)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email already registered. Please use a different email.'
            ]);
        }

        // Insert new user
        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name' => $name
        ];

        if ($userModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Registration successful! Please login.'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Registration failed. Please try again.'
        ]);
    }

    public function signin()
    {
        return view('auth/signin');
    }

    public function login()
    {
        $userModel = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            session()->set([
                'user_id' => $user['id'],
                'user_email' => $user['email'],
                'user_name' => $user['name'],
                'isLoggedIn' => true
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Login successful!'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid email or password.'
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/signin');
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signin');
        }
        return view('auth/profile');
    }

    public function updateProfile()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');

        $existingUser = $userModel->where('email', $email)->where('id !=', $userId)->first();
        if ($existingUser) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email already in use.']);
        }

        if ($userModel->update($userId, ['name' => $name, 'email' => $email])) {
            session()->set(['user_name' => $name, 'user_email' => $email]);
            return $this->response->setJSON(['success' => true, 'message' => 'Profile updated successfully!']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Update failed.']);
    }

    public function changePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signin');
        }
        return view('auth/change_password');
    }

    public function updatePassword()
    {
        $userModel = new UserModel();
        $userId = session()->get('user_id');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        $user = $userModel->find($userId);
        if (!password_verify($currentPassword, $user['password'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Current password is incorrect.']);
        }

        if ($userModel->update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)])) {
            return $this->response->setJSON(['success' => true, 'message' => 'Password changed successfully!']);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Password update failed.']);
    }
}
