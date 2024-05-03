<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\Call;
use App\Models\Ticket;

class ReportService
{
    public function generateAgentPerformanceReport()
    {
        // Query database for agent performance data
        $agentPerformanceData = Agent::withCount('calls')
            ->withAvg('calls', 'duration')
            ->get();

        // Process and format the data into a report format
        $report = [];
        foreach ($agentPerformanceData as $agent) {
            $report[] = [
                'agent_id' => $agent->id,
                'agent_name' => $agent->name,
                'total_calls' => $agent->calls_count,
                'average_duration' => $agent->calls_avg_duration ?: 0,
            ];
        }

        return $report;
    }

    public function generateTicketStatusReport()
    {
        // Query database for ticket status data
        $ticketStatusData = Ticket::select('status', Ticket::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Process and format the data into a report format
        $report = [];
        foreach ($ticketStatusData as $status) {
            $report[] = [
                'status' => $status->status,
                'count' => $status->count,
            ];
        }

        return $report;
    }
}
