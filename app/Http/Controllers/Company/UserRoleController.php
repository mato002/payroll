<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        // TODO: Implement users and roles management
        return view('company.users-roles.index');
    }

    public function create()
    {
        return view('company.users-roles.create');
    }

    public function store(Request $request)
    {
        // TODO: Implement user creation
        return redirect()->route('users-roles.index', ['company' => currentCompany()?->slug]);
    }

    public function edit($user)
    {
        return view('company.users-roles.edit', compact('user'));
    }

    public function update(Request $request, $user)
    {
        // TODO: Implement user update
        return redirect()->route('users-roles.index', ['company' => currentCompany()?->slug]);
    }
}
