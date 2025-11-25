<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Display a listing of the fishes.
     */
    public function index(Request $request)
    {
        $rarity = $request->input('rarity');
        $search = $request->input('search');
        $sortColumn = $request->input('sort', 'name'); // Default sort by name
        $sortDirection = $request->input('direction', 'asc'); // Default sort direction
        
        $fishes = Fish::query() 
            ->byRarity($rarity)
            ->searchByName($search)
            ->sorted($sortColumn, $sortDirection)
            ->paginate(10) // Add pagination with 10 items per page
            ->withQueryString(); // Preserve query parameters when paginating
        
        // Get all possible rarity values for the filter dropdown
        $rarityOptions = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        
        return view('fishes.index', compact('fishes', 'rarityOptions', 'rarity', 'search', 'sortColumn', 'sortDirection'));
    }

    /**
     * Show the form for creating a new fish.
     */
    public function create()
    {
        $rarityOptions = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.create', compact('rarityOptions'));
    }

    /**
     * Store a newly created fish in storage.
     */
    public function store(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|min:0.01|gte:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|min:0.01|max:100.00',
            'description' => 'nullable|string',
        ]);
        
        // Create the new fish
        Fish::create($validated);
        
        return redirect()->route('fishes.index')->with('success', 'Fish created successfully!');
    }

    /**
     * Display the specified fish.
     */
    public function show(Fish $fish)
    {
        // Get the previous and next fish for navigation
        $previousFish = Fish::where('id', '<', $fish->id)->orderBy('id', 'desc')->first();
        $nextFish = Fish::where('id', '>', $fish->id)->orderBy('id', 'asc')->first();
        
        return view('fishes.show', compact('fish', 'previousFish', 'nextFish'));
    }

    /**
     * Show the form for editing the specified fish.
     */
    public function edit(Fish $fish)
    {
        $rarityOptions = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];
        return view('fishes.edit', compact('fish', 'rarityOptions'));
    }

    /**
     * Update the specified fish in storage.
     */
    public function update(Request $request, Fish $fish)
    {
        // Validate the form input
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|min:0.01|gte:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|min:0.01|max:100.00',
            'description' => 'nullable|string',
        ]);
        
        // Update the fish
        $fish->update($validated);
        
        return redirect()->route('fishes.index')->with('success', 'Fish updated successfully!');
    }

    /**
     * Remove the specified fish from storage.
     */
    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Fish deleted successfully!');
    }
}