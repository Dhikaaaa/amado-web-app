<?php

namespace App\Services\NotificationService;

use Illuminate\Http\Request;

interface NotificationTopicService
{
    function sendTopicNotification($topic, $message, $patient_id);
    function saveTopic($patient_id, $topic);
    function updateTopic(Request $request);
    function deleteTopic(Request $request);
    function getTopic(Request $request);
}
