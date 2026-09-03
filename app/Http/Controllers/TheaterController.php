<?php

namespace App\Http\Controllers;

use App\Services\TheaterScheduleService;

class TheaterController extends Controller
{
    protected TheaterScheduleService $theaterService;

    public function __construct(TheaterScheduleService $theaterService)
    {
        $this->theaterService = $theaterService;
    }

    public function index()
    {
        $shows = $this->theaterService->getDelynnSchedule();

        return view('updates', compact('shows'));
    }
}