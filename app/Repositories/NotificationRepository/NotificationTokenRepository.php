<?php

namespace App\Repositories\NotificationRepository;

interface NotificationTokenRepository
{
    function saveToken($pateint_id, $token);
    function updateToken($patent_id, $token);
    function deleteToken($pateint_id, $token);
    function getToken($pateint_id);
}
