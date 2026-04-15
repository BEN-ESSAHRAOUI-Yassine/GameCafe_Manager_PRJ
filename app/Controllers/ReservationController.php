<?php

namespace App\Controllers;

use App\Models\Reservation;
use Core\Controller;
class ReservationController extends Controller
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
        $this->view('reservations/index');
    }

    // ✅ Show create form
    public function create()
    {
        $this->view('reservations/create');
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
            $this->redirect('reservations/index');
        }
    }

    // ✅ Show single reservation
    public function show($id)
    {
        $reservation = $this->reservationModel->getById($id);

        $this->view('my-reservations');
    }

    // ✅ Update status (confirm / cancel)
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $status = $_POST['status'];

            $this->reservationModel->updateStatus($id, $status);

            $this->redirect('reservations/index');
        }
    }

    // ✅ Delete reservation
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $this->reservationModel->delete($id);

            $this->redirect('reservations/index');
        }
    }

    // Disponibilité Table
    // GET /reservations/my
    public function mine(): void {
        $this->requireLogin();
        $reservations = $this->reservationModel->findByUser($this->getUserId());
        $this->view('reservations/my-reservations', ['reservations' => $reservations]);
    }

    // POST /reservations/available
    public function available(): void {
        $reservedAt    = $this->post('reserved_at', '');
        $durationHours = (int) $this->post('duration_hours', 0);

        if (!$reservedAt || !$durationHours) {
            $this->json(['error' => 'Paramètres manquants'], 400);
        }

        $tables = Reservation::getAvailableTables($reservedAt, $durationHours);
        $this->json($tables);
    }
}
