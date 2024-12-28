<?php

require_once __DIR__ . '/../models/TravelPackage.php';
require_once __DIR__ . '/../models/TravelAgency.php';

class TravelPackageController extends Controller
{
    private TravelPackage $travelPackage;
    private TravelAgency $travelAgency;

    public function __construct()
    {
        global $conn;
        $this->travelPackage = new TravelPackage($conn);
        $this->travelAgency = new TravelAgency($conn);
    }

    public function index(): void
    {
        $travelPackages = $this->travelPackage->getAll();
        self::loadView('user/travel-package/index', ['travelPackages' => $travelPackages]);
    }

    public function show($request): void
    {
        $travelPackage = $this->travelPackage->getById($request['id']);


        self::loadView('user/travel-package/show', ['travelPackage' => $travelPackage]);
    }

    public function create(): void
    {
        $travelAgencies = $this->travelAgency->getAll();

        self::loadView('admin/travel-agency/travel-package/create', ['agencies' => $travelAgencies]);
    }

    public function store(): void
    {
        print_r($this->travelPackage->create($_POST));
        exit;
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