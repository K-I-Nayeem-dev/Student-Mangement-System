<?php

namespace App\Http\Controllers;

use App\Models\CoursePurchase;
use Illuminate\Http\Request;

class CoursePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.dashboard.course_purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CoursePurchase $coursePurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CoursePurchase $coursePurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CoursePurchase $coursePurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CoursePurchase $coursePurchase)
    {
        //
    }
}