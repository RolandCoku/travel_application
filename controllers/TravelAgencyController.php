<?php

use JetBrains\PhpStorm\NoReturn;

class TravelAgencyController extends Controller
{

    private TravelAgency $travelAgency;
    private User $user;
    private Log $log;

    public function __construct()
    {
        global $conn;
        $this->travelAgency = new TravelAgency($conn);
        $this->user = new User($conn);
        $this->log = new Log($conn);
    }

    public function index(): void
    {
        $agencies = $this->travelAgency->getAll();

        foreach ($agencies as &$agency) {
            $agency['main_image'] = $this->travelAgency->mainImage($agency['id']);
        }

        self::loadView('user/travel-agency/index', ['agencies' => $agencies]);
    }

    public function show(): void
    {
        // Fetch agency details and all travel packages

        global $conn;
        $agency = $this->travelAgency->getById($_GET['id']);

        if (!$agency) {
            redirect('/travel-agencies', ['error' => 'Agency not found'], 'agencies');
        }

        $agency['main_image'] = $this->travelAgency->mainImage($agency['id']);

        $travelPackages = $this->travelAgency->travelPackages($agency['id']);

        foreach ($travelPackages as &$package) {
            $package['main_image'] = (new TravelPackage($conn))->mainImage($package['id']);
            $reviewResult = (new TravelPackage($conn))->reviews($package['id']);

            $reviews = [];
            $reviewsCount = 0;
            while ($review = $reviewResult->fetch_assoc()) {
                $reviews = [
                    'id' => $review['id'],
                    'rating' => $review['rating'],
                    'created_at' => $review['created_at']
                ];
                $reviewsCount++;
            }
            $averageRating = $reviewsCount > 0 ? array_sum(array_column($reviews, 'rating')) / $reviewsCount : 0;

            $reviews['average_rating'] = $averageRating;

            $package['reviews'] = $reviews;
        }

        $agency = [
            'id' => $agency['id'],
            'name' => $agency['name'],
            'description' => $agency['description'],
            'address' => $agency['address'],
            'phone' => $agency['phone'],
            'website' => $agency['website'],
            'main_image' => $agency['main_image'],
            'travel_packages' => $travelPackages
        ];

        self::loadView('user/travel-agency/show', ['agency' => $agency]);
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

    #[NoReturn] public function store(): void
    {
        // Handle form submission
        $user = $this->user->getByEmail($_POST['email']);

        if (!$user) {
            redirect('/admin/travel-agencies', ['error' => 'User not found'], 'travel-agencies');
        }

        $newAgency = [
            'user_id' => $user['id'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'website' => $_POST['website'],
            'main_image' => $_FILES['main_image'],
            'secondary_images' => $_FILES['secondary_images']
        ];

        if ($this->travelAgency->create($newAgency)) {
            $this->user->updateById($user['id'], ['role' => 'agency_admin']);
            $this->log->log($user['id'], 'Changed role of ' . $user['email'] . ' to agency_admin');
            redirect('/admin/travel-agencies', ['success' => 'Travel agency created successfully'], 'travel-agencies');
        } else {
            redirect('/admin/travel-agencies', ['error' => 'Failed to create travel agency'], 'travel-agencies');
        }
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

    #[NoReturn] public function getPaginatedWithImages(): void
    {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;
        $agencies = $this->travelAgency->paginateWithImages($page, $limit, ['agencies.id', 'agencies.name', 'agencies.description', 'phone', 'address', 'image_url', 'alt_text']);
        header('Content-Type: application/json');
        echo json_encode($agencies);
        exit;
    }

    #[NoReturn] public function getAll(): void
    {
        $agencies = $this->travelAgency->getAll();

        foreach ($agencies as &$agency) {
            $agency['main_image'] = $this->travelAgency->mainImage($agency['id']);
        }

        header('Content-Type: application/json');
        echo json_encode($agencies);
        exit;
    }

}