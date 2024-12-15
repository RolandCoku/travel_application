<?php

class TravelPackageController extends Controller
{
    public static function index(): void
    {
        self::loadView('user/travel-package/index');
    }

    public static function show(): void
    {
        self::loadView('user/travel-package/show');
    }

    public static function create(): void
    {
        self::loadView('admin/travel-agency/travel-packages/create');
    }

    public static function store(): void
    {
        // Handle form submission
    }

    public static function edit(): void
    {
        self::loadView('admin/travel-agency/travel-packages/edit');
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