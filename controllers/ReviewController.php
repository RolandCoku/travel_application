<?php

require_once __DIR__ . '/../models/Review.php';

class ReviewController extends Controller
{
    private Review $review;

    public function __construct()
    {
        global $conn;
        $this->review = new Review($conn);
    }

    public function index(): void
    {
        $reviews = $this->review->getAll();
        self::loadView('admin/reviews', ['reviews' => $reviews]);
    }

    public function show(): void
    {
        $review = $this->review->getById($_GET['id']);
        self::loadView('user/reviews/show', ['review' => $review]);
    }

    public function create(): void
    {
        self::loadView('user/reviews/create');
    }

    public function edit(): void
    {
        $review = $this->review->getById($_GET['id']);

        self::loadView('admin/reviews/edit', ['review' => $review]);
    }

    public function update(): void
    {
        $review = [
            'id' => $_POST['id'],
            'user_id' => $_POST['user_id'],
            'travel_package_id' => $_POST['travel_package_id'],
            'comment' => $_POST['comment'],
            'rating' => $_POST['rating']
        ];

        if ($this->review->update($review)) {
            header('Location: /reviews');
        }
    }

    public function store(): void
    {
        $review = [
            'user_id' => $_POST['user_id'],
            'travel_package_id' => $_POST['travel_package_id'],
            'comment' => $_POST['comment'],
            'rating' => $_POST['rating']
        ];

        if ($this->review->create($review)) {
            header('Location: /reviews');
        }
    }

    public function delete(): void
    {
        if ($this->review->delete($_POST['id'])) {
            header('Location: /reviews');
        }
    }

    // API endpoints
    public function getAllPaginated(): void
    {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 10;

        $reviews = $this->review->paginate($page, $limit, ['reviews.id', 'users.name', 'travel_packages.name', 'comment', 'rating']);
        header('Content-Type: application/json');
        echo json_encode($reviews);
        exit;
    }

    public function getLatestReviews()
    {
        $limit = $_GET['limit'] ?? 5;
        $result = $this->review->getLatestReviews($limit, ['reviews.id', 'users.name', 'travel_packages.name', 'comment', 'rating', 'reviews.created_at']);

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[$row['reviews_id']] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($reviews);
        exit;
    }


}