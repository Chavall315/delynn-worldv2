<?php

namespace App\Http\Controllers;

use App\Services\TheaterScheduleService;
use Illuminate\View\View;

class TheaterController extends Controller
{
    protected TheaterScheduleService $theaterService;

    public function __construct(TheaterScheduleService $theaterService)
    {
        $this->theaterService = $theaterService;
    }

    public function index(): View
    {
        $shows = $this->theaterService->getDelynnSchedule();

        return view('updates', compact('shows'));
    }
}
