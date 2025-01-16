<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Payment.php';


class Booking extends Model{
  // these are the keys that are needed during creation and can be modified later, others are automatically generated
  private const KEYS = ['user_id','agency_id', 'travel_package_id', 'booking_date', 'booking_status'];

  public function __construct(mysqli $conn){
    parent::__construct($conn ,"bookings", Booking::KEYS);
  }


  // We create the booking and then proceed to create the payment
    public function create($obj): bool{

        if(!parent::create(
            [
                'user_id' => $obj['user_id'],
                'agency_id' => $obj['agency_id'],
                'travel_package_id' => $obj['travel_package_id'],
                'booking_date' => $obj['booking_date'],
                'booking_status' => 'approved',
            ]
        )){
            return false;
        }

        $bookingId = $this->conn->insert_id;

        $payment = [
            'booking_id' => $bookingId,
            'payment_date' => $obj['booking_date'],
            'payment_method' => $obj['payment_method'],
            'amount' => $obj['total_price'],
            'payment_status' => 'pending'
        ];

        $paymentModel = new Payment($this->conn);

        if(!$paymentModel->create($payment)){
            return false;
        }
        return true;
    }

    public function createAndGetPaymentId($obj): int|string|null{

      if(!parent::create(
          [
              'user_id' => $obj['user_id'],
              'travel_package_id' => $obj['travel_package_id'],
              'agency_id' => $obj['agency_id'],
              'booking_date' => $obj['booking_date'],
              'booking_status' => 'approved',
          ]
      )){
          return false;
      }

      $bookingId = $this->conn->insert_id;

      $payment = [
          'booking_id' => $bookingId,
          'payment_date' => $obj['booking_date'],
          // 'payment_method' => $obj['payment_method'],
          'amount' => $obj['total_price'],
          'payment_status' => 'pending'
      ];

      $paymentModel = new Payment($this->conn);

      return $paymentModel->createAndGetId($payment);
      // if(!$paymentModel->createAndGetId($payment)){
      //     return null;
      // }
      // return $payment;
  }

    public function getTopDestinations($limit = 3): false|mysqli_result
    {
        $query = "SELECT travel_packages.name, COUNT(bookings.id) as bookings
                  FROM bookings
                  JOIN travel_packages ON bookings.travel_package_id = travel_packages.id
                  GROUP BY travel_packages.name
                  ORDER BY bookings DESC
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $limit);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function paginate(int $page, int $limit, array $keys = ['*']): array
    {
        $offset = ($page - 1) * $limit;

        $aliasedKeys = array_map(function ($key) {
            // Replace the dot (.) with an underscore (_) to create an alias for the column to avoid ambiguity
            return "$key AS " . str_replace('.', '_', $key);
        }, $keys);


        $aliasedKeysString = implode(', ', $aliasedKeys);

        $query = "SELECT $aliasedKeysString FROM $this->table
                        JOIN users ON bookings.user_id = users.id
                        JOIN travel_packages ON bookings.travel_package_id = travel_packages.id
                        JOIN agencies ON travel_packages.agency_id = agencies.id
                        LIMIT ? OFFSET ?;
                        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        //Set the current page and the total number of pages
        $currentPage = $page;
        $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM bookings")->fetch_row()[0] / $limit);

        return [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'data' => $data
        ];
    }

}