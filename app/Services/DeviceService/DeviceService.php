<?php

namespace App\Services\DeviceService;

interface DeviceService {
    function storeDevice($request);
    function updateDevice();
    function deleteDevice();
}