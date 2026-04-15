<?php

namespace App\Controllers;

use App\Models\Reservation;

require_once __DIR__ . '/../models/Reservation.php';

class ReservationController
{
    private $reservationModel;

    public function __construct()
    {
        $this->reservationModel = new Reservation();
    }

    // ✅ Show all reservations
    public function index()
    {
        $reservations = $this->reservationModel->getWithDetails();

        require __DIR__ . '/../views/reservations/index.php';
    }

    // ✅ Show create form
    public function create()
    {
        require __DIR__ . '/../views/reservations/create.php';
    }

    // ✅ Store new reservation (POST)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'user_id' => $_POST['user_id'],
                'table_id' => $_POST['table_id'],
                'party_size' => $_POST['party_size'],
                'reserved_at' => $_POST['reserved_at'],
                'duration_hours' => $_POST['duration_hours'],
                'status' => 'confirmed'
            ];

            $this->reservationModel->create($data);

            // redirect
            header('Location: /marrakech-food-lovers/public/reservations');
            exit;
        }
    }

    // ✅ Show single reservation
    public function show($id)
    {
        $reservation = $this->reservationModel->getById($id);

        require __DIR__ . '/../views/reservations/show.php';
    }

    // ✅ Update status (confirm / cancel)
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $status = $_POST['status'];

            $this->reservationModel->updateStatus($id, $status);

            header('Location: /marrakech-food-lovers/public/reservations');
            exit;
        }
    }

    // ✅ Delete reservation
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $this->reservationModel->delete($id);

            header('Location: /marrakech-food-lovers/public/reservations');
            exit;
        }
    }
}