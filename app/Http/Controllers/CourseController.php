<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    // index
    public function index (Request $request) {
        $query = Course::query();

        // searching
        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('course_category', 'LIKE', "%{$search}%")
                ->orWhere('course_aspect', 'LIKE', "%{$search}%");
            });
        }

        $categories = $query->paginate(25);

        return view('Administrator.CourseCategory.CourseCategoryList', compact('categories'));
    }
    
    // show 
    public function show ($id) {
        $category = Course::with('admin')->find($id);

        if (!$category) {
            return abort(404, "Course Category is not found.");
        }

        return view("Administrator.CourseCategory.CourseCategoryDetails", ['category' => $category]);
    }

    // edit
    public function edit ($id) {
        $category = Course::findOrFail($id);
        return view('Administrator.CourseCategory.update', compact('category'));
    }

    // update
    public function update (Request $request, $id) {
        $category = Course::findOrFail($id);

        $validated_data = $request->validate([
            'course_category' => 'required|string',
            'course_aspect' => 'required|string'
        ]);

        $category->update($validated_data);

        return redirect()->route('coursecategory.list')->with('success', 'Course Category updated successfully.');
    }

    //delete
    public function destroy ($id) {
        $category = Course::findOrFail($id);
        $category->delete();
        return redirect()->route('coursecategory.list')->with('Course Category deleted successfully. ');
    }
    
    // create
    public function create () {
        return view('Administrator.CourseCategory.create');
    }

    // store
    public function store (Request $request) {
        $validated_data = $request->validate([
            'course_category' => 'required|string',
            'course_aspect' => 'required|string'
        ]);

        Course::create($validated_data);

        return redirect()->route('coursecategory.list')->with('success', 'Course category successfully');
    }
}
