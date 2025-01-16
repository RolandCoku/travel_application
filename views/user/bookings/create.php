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
        <td><?php echo $data['agency_name']; ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo $data['name']; ?></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><?php echo $data['description']; ?></td>
    </tr>
    <tr>
        <th>Location</th>
        <td><?php echo $data['location']; ?></td>
    </tr>
    <tr>
        <th>Price</th>
        <td><?php echo $data['price']; ?></td>
    </tr>
    <tr>
        <th>Seats</th>
        <td><?php echo $data['seats']; ?></td>
    </tr>
    <tr>
        <th>Occupied Seats</th>
        <td><?php echo $data['occupied_seats']; ?></td>
    </tr>
    <tr>
        <th>Start Date</th>
        <td><?php echo $data['start_date']; ?></td>
    </tr>
    <tr>
        <th>End Date</th>
        <td><?php echo $data['end_date']; ?></td>
    </tr>
    <tr>
        <th>Created At</th>
        <td><?php echo $data['created_at']; ?></td>
    </tr>
</tbody>
</table>

<form action="/bookings/store" method="POST">
  <input type="hidden" name="travel_package_id" value="<?= $_GET['travel_package_id'] ?>">
  <button type="submit"> Proceed to payment </button>
</form>

<?php include app_path('includes/layout-footer.php'); ?>