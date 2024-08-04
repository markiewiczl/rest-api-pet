<?php

namespace App\Http\Controllers;

use App\Interfaces\PetServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function __construct(
        private readonly PetServiceInterface $petService
    ) {
    }

    public function index(Request $request): View
    {
        $status = $request->query('status', 'available');
        $pets = $this->petService->getPets($status);
        return view('pets.index', compact('pets', 'status'));
    }

    public function show($id): View
    {
        $pet = $this->petService->getPet($id);
        return view('pets.show', compact('pet'));
    }

    public function create(): View
    {
        return view('pets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->petService->addPet($request);
        return redirect()->route('pets.index');
    }

    public function edit($id): View
    {
        $pet = $this->petService->getPet($id);
        return view('pets.edit', compact('pet'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->petService->updatePet($request, $id);
        return redirect()->route('pets.index');
    }

    public function destroy($id): RedirectResponse
    {
        $this->petService->deletePet($id);
        return redirect()->route('pets.index');
    }
}
