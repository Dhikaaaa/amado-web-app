<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HardwareService\Implement\PulseOximetryService;

const EXIST = false;

class PulseOximetryController extends Controller
{
    protected $oximetryService;

    public function __construct(PulseOximetryService $service)
    {
        $this->oximetryService = $service;
    }


    public function storeDataSensor(Request $request)
    {
        $this->oximetryService->storeSensorData($request);
    }


    public function getDataSensor(Request $request)
    {

        $data = $this->oximetryService->getSensorData($request);
        if ($data !== EXIST) {
            return response()->json([
                'code' => 200,
                'data' => $data
            ]);
        }

        return response()->json([
            'code' => 400,
            'status' => 'gagal',
            'message' => 'Device tidak terdaftar'
        ]);
    }
}
