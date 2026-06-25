<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index(Request $request)
    {
        $query = Department::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('college', 'like', "%{$search}%");
            });
        }

        if ($request->filled('active')) {
            $query->where('is_active', $request->input('active') === '1');
        }

        $departments = $query->orderBy('name')->paginate(20)->withQueryString();

        $stats = [
            'total'    => Department::count(),
            'active'   => Department::where('is_active', true)->count(),
            'inactive' => Department::where('is_active', false)->count(),
        ];

        return view('departments.index', compact('departments', 'stats'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['required', 'string', 'max:20', 'unique:departments,code'],
            'description' => ['nullable', 'string'],
            'college'     => ['nullable', 'string', 'max:255'],
            'is_active'   => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $department = Department::create($validated);

        return redirect()->route('departments.show', $department->id)
            ->with('success', "Department '{$department->name}' ({$department->code}) created successfully.");
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department)
    {
        $kpis = $department->kpis()->with('latestResult')->orderBy('measure_code')->get();

        return view('departments.show', compact('department', 'kpis'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'code'        => ['required', 'string', 'max:20', 'unique:departments,code,' . $department->id],
            'description' => ['nullable', 'string'],
            'college'     => ['nullable', 'string', 'max:255'],
            'is_active'   => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $department->update($validated);

        return redirect()->route('departments.show', $department->id)
            ->with('success', "Department '{$department->name}' updated successfully.");
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        $name = $department->name;
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', "Department '{$name}' has been deleted.");
    }
}
