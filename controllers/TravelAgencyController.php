<?php

use JetBrains\PhpStorm\NoReturn;

class TravelAgencyController extends Controller
{

    private TravelAgency $travelAgency;

    public function __construct()
    {
        global $conn;
        $this->travelAgency = new TravelAgency($conn);
    }


    public static function index(): void
    {
        self::loadView('user/travel-agency/index');
    }

    public static function show(): void
    {
        self::loadView('user/travel-agency/show');
    }


    // Admin views
    public function adminDashboard(): void
    {
        self::loadView('admin/travel-agency/index');
    }

    public function bookings(): void
    {
        self::loadView('admin/travel-agency/bookings/index');
    }

    public function travelPackages(): void
    {
        self::loadView('admin/travel-agency/travel-package/index');
    }

    public function reviews(): void
    {
        self::loadView('admin/travel-agency/reviews');
    }

    public function adminShow(): void
    {
        self::loadView('admin/travel-agency/travel-packages/show');
    }

    public function create(): void
    {
        self::loadView('admin/travel-agency/travel-packages/create');
    }

    public function store(): void
    {
        // Handle form submission
    }

    public function edit(): void
    {
        self::loadView('admin/travel-agency/travel-packages/edit');
    }

    public function update(): void
    {
        // Handle form submission
    }

    public function destroy(): void
    {
        // Handle form submission
    }

    // API endpoints
    #[NoReturn] public function paginateTravelAgencies(): void
    {
        $agencies = $this->travelAgency->paginate($_GET['page'], $_GET['limit'], ['agencies.id', 'agencies.name', 'email', 'phone', 'address', 'website']);
        header('Content-Type: application/json');
        echo json_encode($agencies);
        exit;

    }

    #[NoReturn] public function getTopAgencies(): void
    {
        $agencies = $this->travelAgency->getTopAgencies($_GET['limit'] ?? 5);
        header('Content-Type: application/json');
        echo json_encode($agencies);
        exit;
    }

}