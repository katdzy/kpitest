<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Kpi;
use App\Models\KpiAssignment;
use App\Models\Objective;
use App\Models\Perspective;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KpiController extends Controller
{
    /**
     * KPI Library Dashboard — overview of all KPIs by lifecycle status.
     */
    public function dashboard()
    {
        $total = Kpi::count();

        // ── Status Summary ──────────────────────────────────────────
        $statusCounts = [];
        foreach (Kpi::STATUSES as $s) {
            $count = Kpi::where('status', $s)->count();
            $statusCounts[$s] = [
                'count'      => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100) : 0,
            ];
        }

        // ── Category Breakdown ──────────────────────────────────────
        $byCategory = Kpi::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get()
            ->map(fn($r) => [
                'label' => $r->category,
                'count' => (int) $r->total,
                'pct'   => $total > 0 ? round(($r->total / $total) * 100) : 0,
            ]);

        // ── Year Range Breakdown ────────────────────────────────────
        $byYear = Kpi::selectRaw('year_range, count(*) as total')
            ->groupBy('year_range')
            ->orderByDesc('year_range')
            ->get()
            ->map(fn($r) => [
                'label' => $r->year_range,
                'count' => (int) $r->total,
                'pct'   => $total > 0 ? round(($r->total / $total) * 100) : 0,
            ]);

        // ── Scope Breakdown ─────────────────────────────────────────
        $byScope = [
            'Institutional' => Kpi::where('scope', 'Institutional')->count(),
            'Departmental'  => Kpi::where('scope', 'Departmental')->count(),
        ];

        // ── 5-Year Target Trajectory ────────────────────────────────
        $fiveYearPlan = [];
        foreach ([2024, 2025, 2026, 2027, 2028] as $year) {
            $fiveYearPlan[$year] = Kpi::whereNotNull('target_'.$year)
                                      ->where('target_'.$year, '!=', '')
                                      ->count();
        }

        // ── Health Alerts ───────────────────────────────────────────
        $healthAlerts = [
            'no_target'       => Kpi::whereNull('target')->orWhere('target', '')->count(),
            'no_description'  => Kpi::whereNull('description')->orWhere('description', '')->count(),
            'no_data_source'  => Kpi::whereNull('data_source')->orWhere('data_source', '')->count(),
            'no_formula'      => Kpi::whereNull('formula')->orWhere('formula', '')->count(),
            'no_baseline'     => Kpi::whereNull('baseline')->orWhere('baseline', '')->count(),
        ];

        // ── Overdue Submissions Alerts ──────────────────────────────
        $currentYear = '2025-2026';
        $targetField = 'target_2025'; // corresponding target field for the year

        $expectedKpiQuery = Kpi::whereIn('status', ['Active', 'Approved', 'Under Review'])
            ->whereNotNull($targetField)
            ->where($targetField, '!=', '');

        $overdueMidYearKpis = (clone $expectedKpiQuery)
            ->whereDoesntHave('results', function ($q) use ($currentYear) {
                $q->where('school_year', $currentYear)->where('report_type', 'Mid-Year');
            })
            ->get();

        $overdueYearEnderKpis = (clone $expectedKpiQuery)
            ->whereDoesntHave('results', function ($q) use ($currentYear) {
                $q->where('school_year', $currentYear)->where('report_type', 'Year-Ender');
            })
            ->get();

        $healthAlerts['overdue_mid_year'] = $overdueMidYearKpis->count();
        $healthAlerts['overdue_year_ender'] = $overdueYearEnderKpis->count();

        // ── Recently Updated KPIs ───────────────────────────────────
        $recentKpis = Kpi::orderByDesc('updated_at')->limit(8)->get();

        // ── KPIs that just changed status this week ─────────────────
        $recentTransitions = Kpi::whereNotNull('status_changed_at')
            ->where('status_changed_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('status_changed_at')
            ->limit(5)
            ->get();

        return view('kpis.dashboard', compact(
            'total',
            'statusCounts',
            'byCategory',
            'byYear',
            'byScope',
            'fiveYearPlan',
            'healthAlerts',
            'recentKpis',
            'recentTransitions',
            'overdueMidYearKpis',
            'overdueYearEnderKpis'
        ));
    }

    /**
     * Update a KPI's lifecycle status.
     */
    public function updateStatus(Request $request, Kpi $kpi)
    {
        $newStatus = $request->input('status');

        if (!in_array($newStatus, Kpi::STATUSES, true)) {
            return back()->with('error', 'Invalid status value.');
        }

        if (!$kpi->canTransitionTo($newStatus)) {
            return back()->with('error', "Cannot transition from '{$kpi->status}' to '{$newStatus}'.");
        }

        $kpi->transitionTo($newStatus);

        return back()->with('success', "KPI status updated to '{$newStatus}'.");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kpi::query();

        // Search filter (measure code, measure name, measure owner)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('measure_code', 'like', "%{$search}%")
                  ->orWhere('measure_name', 'like', "%{$search}%")
                  ->orWhere('measure_owner', 'like', "%{$search}%");
            });
        }

        // Scope filter (Institutional / Departmental)
        if ($request->filled('scope')) {
            $query->where('scope', $request->input('scope'));
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Year range filter
        if ($request->filled('year_range')) {
            $query->where('year_range', $request->input('year_range'));
        }

        // Lead/Lag filter
        if ($request->filled('lead_lag')) {
            $query->where('lead_lag', $request->input('lead_lag'));
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Perspective filter
        if ($request->filled('perspective_id')) {
            $query->where('perspective_id', $request->input('perspective_id'));
        }

        // Objective filter
        if ($request->filled('objective_id')) {
            $query->where('objective_id', $request->input('objective_id'));
        }

        // Sorting
        $sort = $request->input('sort', 'default');
        $sortOptions = [
            'default'     => ['measure_code', 'asc'],
            'name'        => ['measure_name', 'asc'],
            'theme'       => ['strategic_theme', 'asc'],
            'perspective' => ['perspective_id', 'asc'],
            'objective'   => ['objective_id', 'asc'],
        ];

        [$sortColumn, $sortDir] = $sortOptions[$sort] ?? $sortOptions['default'];

        $query->orderBy($sortColumn, $sortDir);

        // Secondary sort for stability
        if ($sort !== 'default') {
            $query->orderBy('measure_code', 'asc');
        }

        $kpis = $query->orderBy('year_range', 'desc')
                      ->paginate(15)
                      ->withQueryString();

        // Get filter options for dropdowns
        $categories = Kpi::select('category')->distinct()->pluck('category')->toArray();
        
        // Define some standard categories if database is empty
        if (empty($categories)) {
            $categories = ['Academic', 'Research', 'Financial', 'Administration', 'Student Services'];
        }

        $yearRanges = Kpi::select('year_range')->distinct()->orderBy('year_range', 'desc')->pluck('year_range')->toArray();

        // BSC filter options
        $perspectives = Perspective::orderBy('order')->get();
        $objectives   = Objective::with('perspective')->orderBy('order')->get();

        // Basic KPI statistics
        $stats = [
            'total'            => Kpi::count(),
            'lead'             => Kpi::where('lead_lag', 'Lead')->count(),
            'lag'              => Kpi::where('lead_lag', 'Lag')->count(),
            'categories_count' => Kpi::select('category')->distinct()->count(),
            'institutional'    => Kpi::where('scope', 'Institutional')->count(),
            'departmental'     => Kpi::where('scope', 'Departmental')->count(),
        ];

        return view('kpis.index', compact(
            'kpis', 'categories', 'yearRanges', 'stats', 'sort',
            'perspectives', 'objectives'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kpi = null;

        // If cloning from an existing KPI, populate it
        if ($request->filled('clone_from_id')) {
            $kpi = Kpi::find($request->input('clone_from_id'));
        }

        $categories      = ['Academic', 'Research', 'Financial', 'Administration', 'Student Services'];
        $departments     = Department::active()->orderBy('name')->get();
        $parentKpis      = Kpi::where('scope', 'Institutional')
                              ->orderBy('measure_code')
                              ->get(['id', 'measure_code', 'measure_name', 'year_range']);
        $assignmentRoles = KpiAssignment::ROLES;
        $perspectives    = Perspective::orderBy('order')->get();
        $objectives      = Objective::with('perspective')->orderBy('order')->get();

        // Generate a list of academic year ranges for dropdown
        $yearRanges = [];
        $currentYear = date('Y');
        for ($i = -5; $i <= 5; $i++) {
            $start = $currentYear + $i;
            $end = $start + 1;
            $yearRanges[] = "{$start}-{$end}";
        }

        return view('kpis.create', compact(
            'kpi', 'categories', 'yearRanges', 'departments',
            'parentKpis', 'assignmentRoles', 'perspectives', 'objectives'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(Kpi::validationRules());

        $kpi = Kpi::create($validated);

        // Sync department assignments
        $this->syncAssignments($kpi, $request->input('assignments', []));

        return redirect()->route('kpis.show', $kpi->id)
            ->with('success', "KPI '{$kpi->measure_name}' ({$kpi->year_range}) has been successfully created.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Kpi $kpi)
    {
        // Eager-load relationships for the detail page
        $kpi->load([
            'parent',
            'children',
            'departments',
            'latestResult',
            'bscPerspective',
            'bscObjective.perspective',
        ]);

        // Get other versions of this KPI code
        $otherVersions = $kpi->otherVersions();

        return view('kpis.show', compact('kpi', 'otherVersions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kpi $kpi)
    {
        $categories      = ['Academic', 'Research', 'Financial', 'Administration', 'Student Services'];
        $departments     = Department::active()->orderBy('name')->get();
        $parentKpis      = Kpi::where('scope', 'Institutional')
                              ->where('id', '!=', $kpi->id)
                              ->orderBy('measure_code')
                              ->get(['id', 'measure_code', 'measure_name', 'year_range']);
        $assignmentRoles = KpiAssignment::ROLES;
        $perspectives    = Perspective::orderBy('order')->get();
        $objectives      = Objective::with('perspective')->orderBy('order')->get();

        // Current assignments keyed by department_id
        $currentAssignments = $kpi->departments
            ->mapWithKeys(fn($dept) => [$dept->id => $dept->pivot->role])
            ->toArray();
        
        // Generate academic year ranges
        $yearRanges = [];
        $currentYear = date('Y');
        for ($i = -5; $i <= 5; $i++) {
            $start = $currentYear + $i;
            $end = $start + 1;
            $yearRanges[] = "{$start}-{$end}";
        }

        return view('kpis.edit', compact(
            'kpi', 'categories', 'yearRanges', 'departments',
            'parentKpis', 'assignmentRoles', 'currentAssignments',
            'perspectives', 'objectives'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kpi $kpi)
    {
        $validated = $request->validate(Kpi::validationRules($kpi->id));

        $kpi->update($validated);

        // Sync department assignments
        $this->syncAssignments($kpi, $request->input('assignments', []));

        return redirect()->route('kpis.show', $kpi->id)
            ->with('success', "KPI '{$kpi->measure_name}' ({$kpi->year_range}) has been updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kpi $kpi)
    {
        $name = $kpi->measure_name;
        $year = $kpi->year_range;
        $kpi->delete();

        return redirect()->route('kpis.index')
            ->with('success', "KPI '{$name}' version {$year} has been deleted.");
    }

    // ──────────────────────────────────────────────
    // Private Helpers
    // ──────────────────────────────────────────────

    /**
     * Sync department assignments for a KPI.
     *
     * @param  Kpi    $kpi
     * @param  array  $assignments  Array of ['department_id' => X, 'role' => Y]
     */
    private function syncAssignments(Kpi $kpi, array $assignments): void
    {
        // Delete all existing assignments first
        $kpi->departments()->detach();

        foreach ($assignments as $assignment) {
            $deptId = $assignment['department_id'] ?? null;
            $role   = $assignment['role'] ?? 'Contributor';

            if ($deptId && in_array($role, array_keys(KpiAssignment::ROLES))) {
                // attach() will skip duplicates; use updateExistingPivot or sync if needed
                $kpi->departments()->attach($deptId, ['role' => $role]);
            }
        }
    }
}
