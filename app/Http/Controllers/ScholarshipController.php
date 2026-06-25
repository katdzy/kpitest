<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('funding_source', 'like', "%{$s}%")
                  ->orWhere('administering_unit', 'like', "%{$s}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->input('academic_year'));
        }

        if ($request->filled('beneficiary_type')) {
            $query->where('beneficiary_type', $request->input('beneficiary_type'));
        }

        $sort = $request->input('sort', 'default');
        $sortOptions = [
            'default'       => ['title', 'asc'],
            'amount_desc'   => ['amount', 'desc'],
            'amount_asc'    => ['amount', 'asc'],
            'year'          => ['academic_year', 'desc'],
            'beneficiaries' => ['beneficiaries_count', 'desc'],
        ];
        [$sortCol, $sortDir] = $sortOptions[$sort] ?? $sortOptions['default'];
        $query->orderBy($sortCol, $sortDir);

        $scholarships = $query->paginate(15)->withQueryString();

        $academicYears = Scholarship::select('academic_year')->distinct()->orderBy('academic_year', 'desc')->pluck('academic_year')->toArray();

        $stats = [
            'total'        => Scholarship::count(),
            'active'       => Scholarship::where('status', 'Active')->count(),
            'completed'    => Scholarship::where('status', 'Completed')->count(),
            'beneficiaries'=> Scholarship::sum('beneficiaries_count'),
        ];

        return view('scholarships.index', compact('scholarships', 'academicYears', 'stats', 'sort'));
    }

    public function create()
    {
        $yearRanges = $this->yearRanges();
        return view('scholarships.create', compact('yearRanges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Scholarship::validationRules());
        $scholarship = Scholarship::create($validated);

        return redirect()->route('scholarships.show', $scholarship->id)
            ->with('success', "Scholarship/Grant '{$scholarship->title}' has been created successfully.");
    }

    public function show(Scholarship $scholarship)
    {
        return view('scholarships.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship)
    {
        $yearRanges = $this->yearRanges();
        return view('scholarships.edit', compact('scholarship', 'yearRanges'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate(Scholarship::validationRules($scholarship->id));
        $scholarship->update($validated);

        return redirect()->route('scholarships.show', $scholarship->id)
            ->with('success', "'{$scholarship->title}' has been updated successfully.");
    }

    public function destroy(Scholarship $scholarship)
    {
        $title = $scholarship->title;
        $scholarship->delete();

        return redirect()->route('scholarships.index')
            ->with('success', "Scholarship/Grant '{$title}' has been deleted.");
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
