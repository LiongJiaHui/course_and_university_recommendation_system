<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    // login 
    public function login (Request $request) {
        $request->validate([
            'admin_name' => 'required|string|min: 4',
            'password' => 'required|string|min: 8',
        ]);

        $admin = Admin::where('admin_name', $request->admin_name)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->admin_name);
            $request->session()->regenerate();

            return redirect()->route('adminMenu');
        }
        else {
            return back()->withErrors(['admin_name' => 'Invalid credentials.']);
        }
    }
    
    // index 
    public function index(Request $request){
        
        $query = Admin::query();

        // searching section
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('admin_name', 'LIKE', "%{$search}%");
            });
        }

        $admins = $query->paginate(25);

        return view('Administrator.Administrator.administratorList', compact('admins'));
    }

    // logout
    public function logout (Request $request) {
        Auth::logout();
        $request->session()->flush();
        return redirect('/adminLogin');
    }

    // show 
    public function show ($id) {
        $admin = Admin::find($id);

        if(!$admin){
            return abort(404, "User not found");
        }

        return view("Administrator.Administrator.AdministratorDetails", ['admin' => $admin]);
    }

    // edit
    public function edit ($id) {
        $admin = Admin::findOrFail($id);
        return view('Administrator.Administrator.update', compact('admin'));
    }

    // update
    public function update (Request $request, $id) {
        $admin = Admin::findOrFail($id);

        $validated_data = $request->validate([
            'admin_name' => 'required|string|min:4', 
            'password' => 'required|string|min:8'
        ]);

        $admin->update($validated_data);

        return redirect()->route('admin.list')->with('success', 'Admin updated successfully');
    }

    //delete
    public function destroy ($id) {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.list')->with('success', 'Admin deleted Successfully');
    }
    
    // create
    public function create () {
        return view('Administrator.Administrator.create');
    }

    // store
    public function store (Request $request) {
        $validated_data = $request->validate([
            'admin_name' => 'required|string|min: 4', 
            'password' => 'required|string|min: 8'
        ]);

        // hash the password
        $validated_data['password'] = Hash::make($validated_data['password']);

        Admin::create($validated_data);

        return redirect()->route('admin.list')->with('success', 'Admin created successfully.');
    }

}
