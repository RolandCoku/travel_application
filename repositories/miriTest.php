<?php
require_once __DIR__ . '\BookingsRepository.php';

$tpb = new BookingsRepository();
echo $tpb->updateById(32, ["agency_id" => 2, "travel_package_id" => 6]);
echo json_encode($tpb->getById(32));

?>