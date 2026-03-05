<?php

namespace App\Controllers;

use App\Models\MessageModel;
use App\Models\UserModel;

class Chat extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signin');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel
            ->where('id !=', session()->get('user_id'))
            ->findAll();

        return view('chat/index', $data);
    }

    public function sendMessage()
    {
        $messageModel = new MessageModel();

        $data = [
            'sender_id'   => session()->get('user_id'),
            'receiver_id' => $this->request->getPost('receiver_id'),
            'message'     => $this->request->getPost('message')
        ];

        if ($messageModel->insert($data)) {
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false]);
    }

    public function getMessages()
    {
        $messageModel = new MessageModel();
        $receiverId = $this->request->getGet('receiver_id');
        $userId = session()->get('user_id');

        $messages = $messageModel
            ->groupStart()
                ->groupStart()
                    ->where('sender_id', $userId)
                    ->where('receiver_id', $receiverId)
                ->groupEnd()
                ->orGroupStart()
                    ->where('sender_id', $receiverId)
                    ->where('receiver_id', $userId)
                ->groupEnd()
            ->groupEnd()
            ->orderBy('created_at', 'ASC')
            ->findAll();

        return $this->response->setJSON(['success' => true, 'messages' => $messages]);
    }

    public function markAsRead()
    {
        $messageModel = new MessageModel();
        $receiverId = $this->request->getPost('sender_id');
        $userId = session()->get('user_id');

        $messageModel
            ->where('sender_id', $receiverId)
            ->where('receiver_id', $userId)
            ->where('is_read', 0)
            ->set(['is_read' => 1])
            ->update();

        return $this->response->setJSON(['success' => true]);
    }

    public function getUnreadCount()
    {
        $messageModel = new MessageModel();
        $userId = session()->get('user_id');

        $count = $messageModel
            ->where('receiver_id', $userId)
            ->where('is_read', 0)
            ->countAllResults();

        return $this->response->setJSON(['count' => $count]);
    }

    public function uploadFile()
    {
        $file = $this->request->getFile('file');
        $receiverId = $this->request->getPost('receiver_id');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);

            $messageModel = new MessageModel();
            $data = [
                'sender_id'   => session()->get('user_id'),
                'receiver_id' => $receiverId,
                'message'     => '[FILE]' . $newName,
                'file_path'   => $newName
            ];

            if ($messageModel->insert($data)) {
                return $this->response->setJSON(['success' => true, 'file' => $newName]);
            }
        }

        return $this->response->setJSON(['success' => false]);
    }

    public function uploadAudio()
    {
        $audio = $this->request->getFile('audio');
        $receiverId = $this->request->getPost('receiver_id');

        if ($audio && $audio->isValid() && !$audio->hasMoved()) {
            $newName = 'audio_' . time() . '.webm';
            $audio->move(WRITEPATH . 'uploads', $newName);

            $messageModel = new MessageModel();
            $data = [
                'sender_id'   => session()->get('user_id'),
                'receiver_id' => $receiverId,
                'message'     => '[AUDIO]' . $newName,
                'file_path'   => $newName
            ];

            if ($messageModel->insert($data)) {
                return $this->response->setJSON(['success' => true, 'audio' => $newName]);
            }
        }

        return $this->response->setJSON(['success' => false]);
    }
}
