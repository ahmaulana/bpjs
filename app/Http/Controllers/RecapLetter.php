<?php

namespace App\Http\Controllers;

use App\Models\RecapLetter as ModelsRecapLetter;
use Illuminate\Http\Request;

class RecapLetter extends Controller
{
    public function index()
    {
        return view('components.recap.index');
    }

    public function create()
    {
        return view('components.recap.create');
    }

    public function show($id)
    {
        $data = ModelsRecapLetter::findOrFail($id);
        return view('components.recap.show', compact(['data']));
    }

    public function edit($id)
    {
        $data = ModelsRecapLetter::findOrFail($id);
        return view('components.recap.edit', compact(['data']));
    }
}
