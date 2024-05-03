<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function agentPerformance(Request $request)
    {
        // Generate agent performance report
        $report = $this->reportService->generateAgentPerformanceReport();

        // Return the report 
        return response()->json($report);
    }

    public function ticketStatus(Request $request)
    {
        // Generate ticket status report
        $report = $this->reportService->generateTicketStatusReport();

        // Return the report 
        return response()->json($report);
    }
    
    public function generateAgentPerformanceReport(Request $request)
    {
        // Fetch agent performance data from database
        $agents = Agent::withCount('calls')->get();

        // Generate HTML content for the report
        $html = '<h1>Agent Performance Report</h1>';
        $html .= '<table>';
        $html .= '<tr><th>Name</th><th>Total Calls</th></tr>';
        foreach ($agents as $agent) {
            $html .= '<tr><td>' . $agent->name . '</td><td>' . $agent->calls_count . '</td></tr>';
        }
        $html .= '</table>';

        // Generate PDF from HTML
        $pdf = PDF::loadHTML($html);

        // Set file name and options
        $fileName = 'agent_performance_report.pdf';

        // Return the PDF as a downloadable file
        return $pdf->download($fileName);
    }
}
