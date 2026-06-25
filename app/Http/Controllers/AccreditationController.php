<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{
    public function index(Request $request)
    {
        $query = Accreditation::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('program_name', 'like', "%{$s}%")
                  ->orWhere('accrediting_body', 'like', "%{$s}%")
                  ->orWhere('college_department', 'like', "%{$s}%");
            });
        }

        if ($request->filled('level')) {
            $query->where('level', $request->input('level'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('accrediting_body')) {
            $query->where('accrediting_body', $request->input('accrediting_body'));
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->input('academic_year'));
        }

        $sort = $request->input('sort', 'default');
        $sortOptions = [
            'default'     => ['program_name', 'asc'],
            'year'        => ['academic_year', 'desc'],
            'validity'    => ['validity_end', 'asc'],
            'body'        => ['accrediting_body', 'asc'],
        ];
        [$sortCol, $sortDir] = $sortOptions[$sort] ?? $sortOptions['default'];
        $query->orderBy($sortCol, $sortDir);

        $accreditations = $query->paginate(15)->withQueryString();

        $academicYears = Accreditation::select('academic_year')->distinct()->orderBy('academic_year', 'desc')->pluck('academic_year')->toArray();
        $accreditingBodies = Accreditation::select('accrediting_body')->distinct()->pluck('accrediting_body')->toArray();

        $stats = [
            'total'           => Accreditation::count(),
            'active'          => Accreditation::where('status', 'Active')->count(),
            'pending'         => Accreditation::where('status', 'Pending')->count(),
            'expired'         => Accreditation::where('status', 'Expired')->count(),
        ];

        return view('accreditations.index', compact('accreditations', 'academicYears', 'accreditingBodies', 'stats', 'sort'));
    }

    public function create()
    {
        $yearRanges = $this->yearRanges();
        return view('accreditations.create', compact('yearRanges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Accreditation::validationRules());
        $accreditation = Accreditation::create($validated);

        return redirect()->route('accreditations.show', $accreditation->id)
            ->with('success', "Accreditation record for '{$accreditation->program_name}' has been created successfully.");
    }

    public function show(Accreditation $accreditation)
    {
        return view('accreditations.show', compact('accreditation'));
    }

    public function edit(Accreditation $accreditation)
    {
        $yearRanges = $this->yearRanges();
        return view('accreditations.edit', compact('accreditation', 'yearRanges'));
    }

    public function update(Request $request, Accreditation $accreditation)
    {
        $validated = $request->validate(Accreditation::validationRules($accreditation->id));
        $accreditation->update($validated);

        return redirect()->route('accreditations.show', $accreditation->id)
            ->with('success', "Accreditation record for '{$accreditation->program_name}' has been updated.");
    }

    public function destroy(Accreditation $accreditation)
    {
        $name = $accreditation->program_name;
        $accreditation->delete();

        return redirect()->route('accreditations.index')
            ->with('success', "Accreditation record for '{$name}' has been deleted.");
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
