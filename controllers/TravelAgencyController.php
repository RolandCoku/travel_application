<?php

class TravelAgencyController extends Controller
{
    public static function index(): void
    {
        self::loadView('user/travel-agency/index');
    }

    public static function show(): void
    {
        self::loadView('user/travel-agency/show');
    }

    public static function create(): void
    {
        self::loadView('admin/travel-agency/create');
    }

    public static function store(): void
    {
        // Handle form submission
    }

    public static function edit(): void
    {
        self::loadView('admin/travel-agency/edit');
    }

    public static function update(): void
    {
        // Handle form submission
    }

    public static function destroy(): void
    {
        // Handle form submission
    }
}