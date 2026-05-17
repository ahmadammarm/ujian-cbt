<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Inertia\Inertia;
use Inertia\Response;

class AnalyticsController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Analytics', [
            'enrollmentTrends' => $this->analyticsService->getEnrollmentTrends(),
            'coursePerformance' => $this->analyticsService->getCoursePerformance(),
            'passFailRatio' => $this->analyticsService->getPassFailRatio(),
        ]);
    }
}
