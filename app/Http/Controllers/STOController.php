<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoController extends Controller
{
    public function index()
    {
        // Define and sort buildings alphabetically
        $buildings = ['Incoming', 'Office', 'B', 'C', 'A', 'Inhouse', 'Bottom'];
        sort($buildings); // Sort buildings alphabetically

        $employeeCounts = [];

        $positionOrder = [
            'MANAGER',
            'AST. MANAGER',
            'SUPERVISOR',
            'SENIOR STAFF',
            'LEADER',
            'STAFF',
            'OPERATOR'
        ];

        foreach ($buildings as $building) {
            $employeeCounts[$building] = Employee::where('building', $building)
                ->select('position', DB::raw('count(*) as total'))
                ->groupBy('position')
                ->pluck('total', 'position')
                ->toArray();

            // Sort the positions according to the predefined order and filter out zero counts
            $sortedEmployeeCounts = [];
            foreach ($positionOrder as $position) {
                if (isset($employeeCounts[$building][$position]) && $employeeCounts[$building][$position] > 0) {
                    $sortedEmployeeCounts[$position] = $employeeCounts[$building][$position];
                }
            }
            $employeeCounts[$building] = $sortedEmployeeCounts;
        }

        return view('sto.index', compact('employeeCounts', 'buildings', 'positionOrder'));
    }

    public function viewBuilding($building)
    {
        // Validate that the building is valid
        $validBuildings = ['Incoming', 'Office', 'B', 'C', 'A', 'Inhouse', 'Bottom'];
        if (!in_array($building, $validBuildings)) {
            abort(404); // Building not found
        }
    
        // Fetch detailed information about the building, excluding resigned employees
        $employees = Employee::where('building', $building)
            ->where('status', '!=', 'Resigned') // Exclude resigned employees
            ->get();
    
        // Define the position order for sorting
        $positionOrder = [
            'MANAGER',
            'AST. MANAGER',
            'SUPERVISOR',
            'SENIOR STAFF',
            'LEADER',
            'STAFF',
            'OPERATOR'
        ];
    
        // Pass building details and position order to the view
        return view('sto.building', compact('building', 'employees', 'positionOrder'));
    }
}
