<?php 
$title = 'Elite Travel - Create Booking';
$cssFiles = [
  'user/booking/booking-create.css'
];
include app_path('includes/layout-header.php'); 
?>

<body>
<h1>Travel Package Details</h1>

<table>
<tbody>
    <tr>
        <th>Agency Name</th>
        <td><?php echo $data['agency_name'] ?? 'Agency Name'; ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo $data['name'] ?? 'Package Name'; ?></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><?php echo $data['description'] ?? 'Description'; ?></td>
    </tr>
    <tr>
        <th>Location</th>
        <td><?php echo $data['location'] ?? 'Location'; ?></td>
    </tr>
    <tr>
        <th>Price</th>
        <td><?php echo $data['price'] ?? '99.99 USD'; ?></td>
    </tr>
    <tr>
        <th>Seats</th>
        <td><?php echo $data['seats'] ?? '30.'; ?></td>
    </tr>
    <tr>
        <th>Occupied Seats</th>
        <td><?php echo $data['occupied_seats'] ?? '20'; ?></td>
    </tr>
    <tr>
        <th>Start Date</th>
        <td><?php echo $data['start_date'] ?? '30-01-2025'; ?></td>
    </tr>
    <tr>
        <th>End Date</th>
        <td><?php echo $data['end_date'] ?? '01-02-2025'; ?></td>
    </tr>
    <tr>
        <th>Created At</th>
        <td><?php echo $data['created_at'] ?? '21-01.2025'; ?></td>
    </tr>
</tbody>
</table>

<form action="/bookings/store" method="POST">
  <input type="hidden" name="travel_package_id" value="<?= $_GET['travel_package_id'] ?? -1 ?>">
  <button type="submit"> Proceed to payment </button>
</form>

<?php include app_path('includes/layout-footer.php'); ?>