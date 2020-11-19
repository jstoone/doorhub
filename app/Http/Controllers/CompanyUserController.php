<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        return $company->users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $userId = $request->validate([
            'id' => 'required|exists:users,id',
        ])['id'];

        $user = tap(User::find($userId), function ($user) use ($company) {
            $user->company()->associate($company)->save();
        });

        return response($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, User $user)
    {
        //
    }
}
