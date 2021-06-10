<?php

namespace App\Repositories\NotificationRepository\Implement;

use App\Models\Notification\Notification;
use App\Repositories\NotificationRepository\NotificationTokenRepository;
use App\Repositories\NotificationRepository\NotificationTopicRepository;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\Log;

class PatientNotificationRepository implements NotificationTokenRepository, NotificationTopicRepository
{

    protected $patientModel;
    protected $notification;

    public function __construct(Patient $model, Notification $notification)
    {
        $this->patientModel = $model;
        $this->notification = $notification;
    }

    /**
     * * Handle Firebase API token
     */
    // TODO hapus fungsi
    public function saveToken($patient_id, $token)
    {
    }


    public function deleteToken($patient_id, $token = ""): String
    {
        $this->patientModel::where('id', $patient_id)->update(['firebase_api_token' => $token]);

        Log::info('Delete firebase api token to empty string: patientModel::where("id", $patient_id)->update(["firebase_api_token" => $token]);');

        return $this->patientModel::find($patient_id)->firebase_api_token;
    }


    public function updateToken($patient_id, $token = ""): Patient
    {
        $this->patientModel::where('id', $patient_id)->update(['firebase_api_token' => $token]);

        Log::info('Update firebase api token: patientModel::where("id", $patient_id)->update(["firebase_api_token" => $token])');

        return $this->patientModel::find($patient_id);
    }


    public function getToken($patient_id): string
    {
        return $this->patientModel::find($patient_id)->firebase_api_token;

        Log::info("Get patient firebase api token");
    }



    /**
     * * Handle Firebase Topic Notificaton
     */
    public function saveTopic($patient_id, $topic)
    {
    }


    public function deleteTopic($patient_id, $topic)
    {
        $patient = $this->patientModel::find($patient_id);
        Log::info("find patient model with id {$patient_id}");

        $patient->notificationTemplate()->detach($topic);
        Log::info("Detach patient with notification id {$topic}");

        return $this->patientModel::find($patient_id)->notificationTemplate()->get()->all();
        Log::info("Return patient notification that has been attached");
    }


    public function updateTopic($patient_id, $topic)
    {
        $patient = $this->patientModel::find($patient_id);
        Log::info("find patient model with id {$patient_id}");

        $patient->notificationTemplate()->attach($topic);
        Log::info("Attach patient with notification id {$topic}");

        return $this->patientModel::find($patient_id)->notificationTemplate()->get()->all();
        Log::info("Return patient notification that has been attached");
    }


    public function getTopics($patient_id)
    {
        return $this->patientModel::find($patient_id)->notificationTemplate()->get()->all();

        Log::info("get all topics from patient id {$patient_id}");
    }

    public function getTopic($patient_id, $topic)
    {
    }

    public function getPatient($patient_id)
    {
    }

    public function getPhoto($patient_id)
    {
    }
}
