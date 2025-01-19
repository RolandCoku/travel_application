<?php

class AdminController extends Controller
{
    public function dashboard(): void
    {
        self::loadView('admin/index');
    }

    public function agencies(): void
    {
        self::loadView('admin/agencies');
    }

    public function bookings(): void
    {
        self::loadView('admin/bookings');
    }

    public function reviews(): void
    {
        self::loadView('admin/reviews');
    }

    public function travelPackages(): void
    {
        self::loadView('admin/travel-packages');
    }

    public function registerAgency(): void
    {
        self::loadView('admin/travel-agency/create');
    }

    public function profile(): void
    {
        self::loadView('admin/profile');
    }

}