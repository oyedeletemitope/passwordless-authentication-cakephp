<?php

namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Twilio');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->loadModel('Users');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow unauthenticated users to access these actions
        $this->Authentication->allowUnauthenticated(['requestCode', 'verifyCode']);
    }

    public function requestCode()
    {
        if ($this->request->is('post')) {
            $phone = $this->request->getData('phone');
            $code = rand(100000, 999999);

            $user = $this->Users->findByPhone($phone)->first();
            if (!$user) {
                $user = $this->Users->newEmptyEntity();
            }
            $user->phone = $phone;
            $user->code = $code;
            if ($this->Users->save($user)) {
                $this->Twilio->sendVerificationCode($phone, $code);
                $this->request->getSession()->write('verified_user_id', $user->id);
                $this->Flash->success('Verification code sent.');
                return $this->redirect(['action' => 'verifyCode']);
            }
            $this->Flash->error('Unable to send verification code.');
        }
    }

    public function verifyCode()
    {
        if ($this->request->is('post')) {
            $code = $this->request->getData('code');
            $userId = $this->request->getSession()->read('verified_user_id');

            if ($userId) {
                $user = $this->Users->get($userId);
                if ($user && $user->code == $code) {
                    $this->Authentication->setIdentity($user);
                    $this->Flash->success('You are logged in.');
                    return $this->redirect(['action' => 'dashboard']);
                } else {
                    $this->Flash->error('Invalid verification code.');
                }
            } else {
                $this->Flash->error('Session expired or user not found.');
            }
        }
    }

    public function dashboard()
    {
        // You can add more logic here if needed
        $this->set('title', 'Dashboard');
    }
}
