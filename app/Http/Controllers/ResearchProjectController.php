<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ResearchProject;
use Illuminate\Http\Request;

class ResearchProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = ResearchProject::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('lead_researcher', 'like', "%{$s}%")
                  ->orWhere('keywords', 'like', "%{$s}%")
                  ->orWhere('implementing_unit', 'like', "%{$s}%");
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

        if ($request->filled('output_type')) {
            $query->where('output_type', $request->input('output_type'));
        }

        $sort = $request->input('sort', 'default');
        $sortOptions = [
            'default'    => ['title', 'asc'],
            'year'       => ['academic_year', 'desc'],
            'funding'    => ['funding_amount', 'desc'],
            'researcher' => ['lead_researcher', 'asc'],
            'start_date' => ['start_date', 'desc'],
        ];
        [$sortCol, $sortDir] = $sortOptions[$sort] ?? $sortOptions['default'];
        $query->orderBy($sortCol, $sortDir);

        $researchProjects = $query->paginate(15)->withQueryString();

        $academicYears = ResearchProject::select('academic_year')->distinct()->orderBy('academic_year', 'desc')->pluck('academic_year')->toArray();

        $stats = [
            'total'      => ResearchProject::count(),
            'ongoing'    => ResearchProject::where('status', 'Ongoing')->count(),
            'published'  => ResearchProject::where('status', 'Published')->count(),
            'total_funding' => ResearchProject::sum('funding_amount'),
        ];

        return view('research.index', compact('researchProjects', 'academicYears', 'stats', 'sort'));
    }

    public function create()
    {
        $yearRanges = $this->yearRanges();
        return view('research.create', compact('yearRanges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(ResearchProject::validationRules());
        $project = ResearchProject::create($validated);

        return redirect()->route('research.show', $project->id)
            ->with('success', "Research Project '{$project->title}' has been created successfully.");
    }

    public function show(ResearchProject $research)
    {
        return view('research.show', compact('research'));
    }

    public function edit(ResearchProject $research)
    {
        $yearRanges = $this->yearRanges();
        return view('research.edit', compact('research', 'yearRanges'));
    }

    public function update(Request $request, ResearchProject $research)
    {
        $validated = $request->validate(ResearchProject::validationRules($research->id));
        $research->update($validated);

        return redirect()->route('research.show', $research->id)
            ->with('success', "Research Project '{$research->title}' has been updated.");
    }

    public function destroy(ResearchProject $research)
    {
        $title = $research->title;
        $research->delete();

        return redirect()->route('research.index')
            ->with('success', "Research Project '{$title}' has been deleted.");
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
