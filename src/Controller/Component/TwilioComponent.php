<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Twilio\Rest\Client;
use Cake\Log\Log;

class TwilioComponent extends Component
{
    private $client;

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $sid = getenv('TWILIO_ACCOUNT_SID'); // Replace with your actual Twilio SID
        $token = getenv('TWILIO_AUTH_TOKEN'); // Replace with your actual Twilio token

        $this->client = new Client($sid, $token);
    }

    public function sendVerificationCode($to, $code)
    {
        try {
            $message = $this->client->messages->create(
                $to,
                [
                    'from' => getenv('TWILIO_PHONE_NUMBER'), // Your Twilio phone number
                    'body' => "Your verification code is: $code"
                ]
            );
        } catch (\Twilio\Exceptions\RestException $e) {
            Log::error("Failed to send SMS: {$e->getMessage()}");
        }
    }
}
