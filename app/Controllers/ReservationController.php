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
        $this->requireAdmin();

        $reservations = $this->reservationModel->getWithDetails();

        $this->view('reservations/index', [
            'reservations' => $reservations
        ]);
    }

    // ✅ Show create form
    public function create()
    {
        $this->requireLogin();

        $this->view('reservations/create');
    }

    // ✅ Store new reservation (POST)
    public function store() 
    {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'user_id'        => $this->getUserId(), // ✅ NEVER trust POST user_id
                'table_id'       => $_POST['table_id'] ?? 1, // add number of table 
                'party_size'     => $_POST['party_size'] ?? 1,
                'reserved_at'    => $_POST['reserved_at'] ?? null,
                'duration_hours' => $_POST['duration_hours'] ?? 1,
                'status'         => 'pending'
            ];

            $this->reservationModel->create($data);

            // redirect
            $this->redirect('/reservations/my');
        }
    }

    // ✅ Show single reservation
    public function show($id = null)
    {
        $this->requireLogin();

        $reservation = $this->reservationModel->getById($id);

        if (!$reservation) {
            $this->notFound();
            return;
        }

        $this->view('reservations/show', [
            'reservation' => $reservation
        ]);
    }

    // ✅ Update status (confirm / cancel)
    public function updateStatus($id = null)
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // $id comes from URL, status from POST
            $status = $_POST['status'] ?? null;

            if ($id && $status) {
                $this->reservationModel->updateStatus($id, $status);
            }

            $this->redirect('/reservations');
        }
    }

    // ✅ Delete reservation
    public function delete()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'] ?? null;

            if ($id) {
                $this->reservationModel->delete($id);
            }

            $this->redirect('/reservations');
        }
    }

    // Disponibilité Table
    // GET /reservations/my
    public function mine(): void {
        $this->requireLogin();

        $reservations = $this->reservationModel->findByUser($this->getUserId());

        $this->view('reservations/my-reservations', [
            'reservations' => $reservations
        ]);
    }

    // POST /reservations/available
    public function available(): void {
        $reservedAt    = $this->post('reserved_at', '');
        $durationHours = (int) $this->post('duration_hours', 0);

        if (!$reservedAt || !$durationHours) {
            $this->json(['error' => 'Paramètres manquants'], 400);
            return;
        }

        $tables = Reservation::getAvailableTables($reservedAt, $durationHours);

        $this->json($tables);
    }
}
