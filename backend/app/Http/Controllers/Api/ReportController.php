<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function __construct(private ReportService $reports) {}

    public function rooms(): JsonResponse
    {
        return response()->json(['data' => $this->reports->roomSummary()]);
    }
}
