<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json($categories);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve categories.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            $imageUrl = null;

            // Check if an image file was uploaded
            if ($request->hasFile('image')) {
                // Store the image in the 'public' disk and get its path
                $imagePath = $request->file('image')->store('images/categories', 'public');

                // Log the stored image path for debugging
                Log::info('Stored Image Path: ' . $imagePath);
                Log::info('Stored Image Absolute Path: ' . storage_path('app/public/' . $imagePath));

                // Generate the public URL for the image
                $imageUrl = Storage::url($imagePath);

                // Log the generated URL for debugging
                Log::info('Image URL: ' . $imageUrl);
            }

            // Create the category
            $category = Category::create([
                'name' => $request->input('name'),
                'image' => $imageUrl, // Use the image URL or keep it null if no image was uploaded
            ]);

            // Return a success response with the category data
            return response()->json([
                'message' => 'Category created successfully!',
                'category' => $category
            ], 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            // Handle other exceptions
            Log::error('Error creating category: ' . $e->getMessage()); // Log the error for debugging
            return response()->json([
                'message' => 'Failed to create category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            $category = Category::findOrFail($id);

            if ($request->hasFile('image')) {
                $category->image = $request->file('image')->store('images/categories', 'public');
            }

            $category->name = $request->input('name');
            $category->save();

            return response()->json([
                'message' => 'Category updated successfully!',
                'category' => $category,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete category.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
