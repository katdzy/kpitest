<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OutreachProgram;
use Illuminate\Http\Request;

class OutreachProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = OutreachProgram::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('program_name', 'like', "%{$s}%")
                  ->orWhere('implementing_unit', 'like', "%{$s}%")
                  ->orWhere('target_community', 'like', "%{$s}%")
                  ->orWhere('location', 'like', "%{$s}%");
            });
        }

        if ($request->filled('program_type')) {
            $query->where('program_type', $request->input('program_type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->input('academic_year'));
        }

        $sort = $request->input('sort', 'default');
        $sortOptions = [
            'default'       => ['program_name', 'asc'],
            'year'          => ['academic_year', 'desc'],
            'beneficiaries' => ['beneficiaries_count', 'desc'],
            'start_date'    => ['start_date', 'desc'],
        ];
        [$sortCol, $sortDir] = $sortOptions[$sort] ?? $sortOptions['default'];
        $query->orderBy($sortCol, $sortDir);

        $outreachPrograms = $query->paginate(15)->withQueryString();

        $academicYears = OutreachProgram::select('academic_year')->distinct()->orderBy('academic_year', 'desc')->pluck('academic_year')->toArray();

        $stats = [
            'total'        => OutreachProgram::count(),
            'ongoing'      => OutreachProgram::where('status', 'Ongoing')->count(),
            'completed'    => OutreachProgram::where('status', 'Completed')->count(),
            'beneficiaries'=> OutreachProgram::sum('beneficiaries_count'),
        ];

        return view('outreach.index', compact('outreachPrograms', 'academicYears', 'stats', 'sort'));
    }

    public function create()
    {
        $yearRanges = $this->yearRanges();
        return view('outreach.create', compact('yearRanges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(OutreachProgram::validationRules());
        $program = OutreachProgram::create($validated);

        return redirect()->route('outreach.show', $program->id)
            ->with('success', "Outreach Program '{$program->program_name}' has been created successfully.");
    }

    public function show(OutreachProgram $outreach)
    {
        return view('outreach.show', compact('outreach'));
    }

    public function edit(OutreachProgram $outreach)
    {
        $yearRanges = $this->yearRanges();
        return view('outreach.edit', compact('outreach', 'yearRanges'));
    }

    public function update(Request $request, OutreachProgram $outreach)
    {
        $validated = $request->validate(OutreachProgram::validationRules($outreach->id));
        $outreach->update($validated);

        return redirect()->route('outreach.show', $outreach->id)
            ->with('success', "'{$outreach->program_name}' has been updated successfully.");
    }

    public function destroy(OutreachProgram $outreach)
    {
        $name = $outreach->program_name;
        $outreach->delete();

        return redirect()->route('outreach.index')
            ->with('success', "Outreach Program '{$name}' has been deleted.");
    }

    private function yearRanges(): array
    {
        $ranges = [];
        $currentYear = date('Y');
        for ($i = -5; $i <= 5; $i++) {
            $start = $currentYear + $i;
            $ranges[] = "{$start}-" . ($start + 1);
        }
        return $ranges;
    }
}
