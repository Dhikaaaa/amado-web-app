<?php

namespace App\Repositories\NotificationRepository;

interface NotificationTopicRepository
{
    function saveTopic($patient_id, $topic);
    function deleteTopic($patient_id, $topic);
    function updateTopic($patient_id, $topic);
    function getTopic($patient_id, $topic);
}
