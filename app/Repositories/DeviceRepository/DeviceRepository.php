<?php

namespace App\Repositories\DeviceRepository;

use App\Models\Device\UserDevice;

interface DeviceRepository
{
    function saveDevice($patientId, $serialNumber): UserDevice;
    function updateDevice();
    function deleteDevice();
}
