<?php

class SearchController extends Controller
{
  public function search(){
    require_once app_path('models/TravelAgency.php');
    require_once app_path('models/TravelPackage.php');
    require_once app_path('models/Image.php');
    global $conn;
    $travelAgencyRepo = new TravelAgency($conn);
    $travelPackageRepo = new TravelPackage($conn);
    $input = htmlspecialchars($_GET['travel-search'], ENT_QUOTES, 'UTF-8');
    $agencies = $travelAgencyRepo->searchInColumns($input, ['name', 'description']);
    $packages = $travelPackageRepo->searchInColumns($input, ['name', 'description', 'location']);

    // $imageRepo = new Image($conn);
    foreach( $agencies as &$agency){  //images
      // $primaryImage = $imageRepo->getImagesByEntity('agency', $agency['id'])->fetch_assoc()['image_url'];
      $primaryImage = 'assets/placeholder-image.webp';
      $agency['image_url'] = $primaryImage;
    }
    foreach( $packages as &$package){
      // $primaryImage = $imageRepo->getImagesByEntity('travel_package', $package['id'])->fetch_assoc()['image_url'];
      $primaryImage = 'assets/placeholder-image.webp';
      $package['image_url'] = $primaryImage;
    }
    $this->loadView('user/search', ['agencies' => $agencies, 'packages' => $packages]);
  }
}
