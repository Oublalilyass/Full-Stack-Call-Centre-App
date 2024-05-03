
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReportController;


Route::apiResource('tickets', 'TicketController');
// Routes for CallController
Route::post('/calls', [CallController::class, 'store']); // Create a new call record
// Routes for TicketController
Route::post('/tickets', [TicketController::class, 'store']); // Create a new ticket record
//Reports
Route::get('/reports/agent-performance', [ReportController::class, 'agentPerformance']);
Route::get('/reports/ticket-status', [ReportController::class, 'ticketStatus']);
//Supervisors
Route::get('/supervisors', [SupervisorController::class, 'index']);
Route::post('/supervisor/register', 'SupervisorController@register');
Route::post('/supervisor/login', 'SupervisorController@login');

