<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    // Show create form (web) OR categories (api)
    public function create(Request $request)
    {
        try {
            $categories = Category::all();

            if ($request->wantsJson()) {
                return response()->json([
                    'categories' => $categories,
                ], 200);
            }

            return view('services.create', compact('categories'));
        } catch (Exception $e) {
            Log::error('Error loading service create page: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load categories'], 500);
        }
    }

    // List services (web) OR services+categories (api)
    public function index(Request $request)
    {
        try {
            $services = Service::with('category')->get();
            $categories = Category::all();

            if ($request->wantsJson()) {
                return response()->json([
                    'services' => $services,
                    'categories' => $categories,
                ], 200);
            }

            return view('pages.service', compact('services', 'categories'));
        } catch (Exception $e) {
            Log::error('Error fetching services: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch services'], 500);
        }
    }

    // Store (web redirect) OR (api json)
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
                'new_category' => 'nullable|string|max:255',
                'gender' => 'required|in:Male,Female,Both',
                'category_id' => 'nullable|exists:categories,id',
                'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Must choose existing category or add new category
            if (!$request->filled('category_id') && !$request->filled('new_category')) {
                // web -> back with error
                if (!$request->wantsJson()) {
                    return back()->withErrors(['category' => 'Please select or enter a category.'])->withInput();
                }
                // api -> json error
                return response()->json(['error' => 'Please select or enter a category.'], 422);
            }

            // Category handling
            if ($request->filled('new_category')) {
                $categoryId = Category::create(['name' => $request->new_category])->id;
            } else {
                $categoryId = $request->category_id;
            }

            $service = Service::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'gender' => $request->gender,
                'category_id' => $categoryId,
                'image_path' => $request->file('service_image')
                    ? $request->file('service_image')->store('services', 'public')
                    : null,
            ]);

            // API response
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Service added successfully!',
                    'service' => $service,
                ], 201);
            }

            // Web response
            return redirect()->route('services')->with('success', 'Service added successfully!');
        } catch (Exception $e) {
            Log::error('Error storing service: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json(['error' => 'Failed to add service'], 500);
            }

            return back()->with('error', 'Failed to add service')->withInput();
        }
    }

    // Show one service (api)
    public function show($id)
    {
        try {
            $service = Service::findOrFail($id);

            return response()->json([
                'service' => $service,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error fetching service: ' . $e->getMessage());
            return response()->json(['error' => 'Service not found'], 404);
        }
    }

    // Update (api)
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string|max:1000',
                'new_category' => 'nullable|string|max:255',
                'gender' => 'required|in:Male,Female,Both',
                'category_id' => 'nullable|exists:categories,id',
                'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $service = Service::findOrFail($id);

            if ($request->filled('new_category')) {
                $categoryId = Category::create(['name' => $request->new_category])->id;
            } else {
                $categoryId = $request->category_id;
            }

            $service->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'gender' => $request->gender,
                'category_id' => $categoryId,
                'image_path' => $request->file('service_image')
                    ? $request->file('service_image')->store('services', 'public')
                    : $service->image_path,
            ]);

            return response()->json([
                'message' => 'Service updated successfully!',
                'service' => $service,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating service: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update service'], 500);
        }
    }

    // Delete (api)
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return response()->json(['message' => 'Service deleted successfully'], 200);
        } catch (Exception $e) {
            Log::error('Error deleting service: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete service'], 500);
        }
    }
}
