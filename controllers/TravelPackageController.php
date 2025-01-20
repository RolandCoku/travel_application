<?php

use JetBrains\PhpStorm\NoReturn;

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
    self::loadView('user/travel-package/index');
  }

  public function show(): void
  {
    self::loadView('user/travel-package/show');
  }

  public function create(): void
  {
    self::loadView('admin/travel-agency/travel-package/create');
  }

  public function store(): void
  {
    $travelPackage = [
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'location' => $_POST['location'],
      'seats' => $_POST['seats'],
      'price' => $_POST['price'],
      'start_date' => $_POST['start_date'],
      'end_date' => $_POST['end_date'],
      'agency_id' => $_POST['agency_id'] ?? $_SESSION['agency_id'] ?? 37
    ];

    if ($this->travelPackage->create($travelPackage)) {
      header('Location: /travel-packages');
    } else {
      echo 'Error creating travel package';
    }
  }

  public function edit(): void
  {
    $travelPackage = $this->travelPackage->getById($_GET['id']);
    require_once app_path('models/Image.php');
    // $travelPackage['images'] = $this->travelPackage->images($travelPackage['id']);
    //  $travelAgencies = $this->travelAgency->getAll();
    global $conn;
    $imageR = new Image($conn);
    $travelPackage['images'] = $imageR->getImagesByEntity('travel_package', $travelPackage['id'])->fetch_all();
    error_log("HERE< HERE< HERE" . json_encode($travelPackage['images']));
    self::loadView('admin/travel-agency/travel-package/edit', $travelPackage);
  }

  public function update(): void
  {
    $travelPackage = [
      'id' => $_POST['id'],
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'location' => $_POST['location'],
      'seats' => $_POST['seats'],
      'price' => $_POST['price'],
      'start_date' => $_POST['start_date'],
      'end_date' => $_POST['end_date'],
      'agency_id' => $_POST['agency_id'] ?? $_SESSION['agency_id'] ?? 37
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

  public function adminShow() {}

  public function getAllPaginated()
  {
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 10;
    $travelPackages = $this->travelPackage->paginate($page, $limit, ['travel_packages.id', 'travel_packages.name', 'travel_packages.description', 'price', 'start_date', 'end_date', 'agencies.name', 'seats', 'occupied_seats']);

    header('Content-Type: application/json');
    echo json_encode($travelPackages);
    exit;
  }

  public function getTopPackages()
  {
    $limit = $_GET['limit'] ?? 5;
    $travelPackages = $this->travelPackage->getTopPackages($limit, ['travel_packages.id', 'travel_packages.name']);
    header('Content-Type: application/json');
    echo json_encode($travelPackages);
    exit;
  }

  #[NoReturn] public function getPaginatedWithImages(): void
  {
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 10;
    $result = $this->travelPackage->paginateWithImages($page, $limit);

    $travelPackages = [];

    while ($row = $result->fetch_assoc()) {
      $mainImage = [];

      if (!empty($row['main_image_url'])) {
        $mainImage = [
          'image_url' => $row['main_image_url'],
          'alt_text' => $row['main_image_alt_text']
        ];
      }

      $secondaryImages = [];

      if (!empty($row['secondary_image_urls'])) {
        $secondaryImageUrls = explode(',', $row['secondary_image_urls']);
        $secondaryImageAltTexts = explode(',', $row['secondary_image_alt_texts']);

        foreach ($secondaryImageUrls as $key => $secondaryImageUrl) {
          $secondaryImages[] = [
            'image_url' => $secondaryImageUrl,
            'alt_text' => $secondaryImageAltTexts[$key]
          ];
        }
      }

      $travelPackages[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'location' => $row['location'],
        'price' => $row['price'],
        'start_date' => $row['start_date'],
        'end_date' => $row['end_date'],
        'free_seats' => $row['seats'] - $row['occupied_seats'],
        'main_image' => $mainImage,
        'secondary_images' => $secondaryImages
      ];
    }

    $totalPages = $this->travelPackage->getTotalPages($limit);

    $travelPackages = [
      'currentPage' => $page,
      'totalPages' => $totalPages,
      'data' => $travelPackages
    ];

    header('Content-Type: application/json');
    echo json_encode($travelPackages);
    exit;
  }

  // For specific agency now
  public function getAllPaginatedForAgency()
  {
    $agency = $_SESSION['agency_id'] ?? 37;
    $page = $_GET['page'] ?? 1;
    $limit = $_GET['limit'] ?? 10;
    $travelPackages = $this->travelPackage->paginateForAgency($page, $limit, $agency);

    header('Content-Type: application/json');
    echo json_encode($travelPackages);
    exit;
  }
}
