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

    public function show(): void
    {
//        $travelPackage = $this->travelPackage->getById($_GET['id']);
        self::loadView('user/travel-package/show');
    }

    public function create(): void
    {
        $travelAgencies = $this->travelAgency->getAll();

        self::loadView('admin/travel-agency/travel-package/create', ['agencies' => $travelAgencies]);
    }

    public function store(): void
    {
        $travelPackage = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'agency_id' => $_POST['agency_id']
        ];

        if ($this->travelPackage->create($travelPackage)) {
            header('Location: /travel-packages');
        } else {
            echo 'Error creating travel package';
        }
    }

    public function edit(): void
    {
//        $travelPackage = $this->travelPackage->getById($_GET['id']);
//        $travelPackage['images'] = $this->travelPackage->images($travelPackage['id']);
//        $travelAgencies = $this->travelAgency->getAll();

        self::loadView('admin/travel-agency/travel-package/edit');
    }

    public function update(): void
    {
        $travelPackage = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'agency_id' => $_POST['agency_id']
        ];

        if ($this->travelPackage->update($travelPackage)) {
            header('Location: /travel-packages');
        } else {
            echo 'Error updating travel package';
        }
    }

    public function destroy(): void
    {
        $this->travelPackage->delete($_GET['id']);
        header('Location: /travel-packages');
    }

    public function adminShow()
    {
    }
}