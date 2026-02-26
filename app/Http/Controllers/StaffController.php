<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    public function create()
{
    $categories = Category::all(); // Fetch categories for the dropdown
    return view('staff.create', compact('categories')); // Return the create view with categories
}

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit($id)
    {
        $staff = Staff::with('categories')->findOrFail($id);
        $categories = Category::all();
        return view('staff.edit', compact('staff', 'categories'));
    }

    public function index(Request $request)
    {
        try {
            // Retrieve all staff members with their associated categories
            $staffMembers = Staff::with('categories')->get();
            $categories = Category::all();  // Fetch all categories for the dropdown

            // Check if the request expects a JSON response
            if ($request->wantsJson()) {
                // If the request wants a JSON response, return data as JSON
                $result = $staffMembers->map(function ($staff) {
                    return [
                        'id' => $staff->id,
                        'name' => $staff->name,
                        'contact_number' => $staff->contact_number,
                        'ratings' => $staff->ratings,
                        'categories' => $staff->categories->map(function ($category) {
                            return [
                                'id' => $category->id,
                                'name' => $category->name,
                                'image' => $category->image,
                            ];
                        })
                    ];
                });

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            }

            // If the request does not want JSON, return a Blade view
            return view('pages.staff', compact('staffMembers', 'categories'));
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the staff members.',
                'error' => $e->getMessage() // Optionally include the exception message for debugging
            ], 500);
        }
    }

    public function store(Request $request)
    {
        
            //dd($request);
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:15',
                'ratings' => 'required|integer|min:0|max:5',
                'category_ids' => 'required|array',
                'category_ids.*' => 'exists:categories,id', // Ensure each ID exists in the categories table
                'experience' => 'nullable|string|max:255',
                'join_date' => 'nullable|date',
                'bank_account_number' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'basic_salary' => 'nullable|numeric|min:0',
                'etf_number' => 'nullable|string|max:255',
            ]);
        try {
            // Create a new staff member
            $staff = Staff::create([
                'name' => $request->input('name'),
                'contact_number' => $request->input('contact_number'),
                'ratings' => $request->input('ratings'),
                'experience' => $request->input('experience'),
                'join_date' => $request->input('join_date'),
                'bank_account_number' => $request->input('bank_account_number'),
                'bank_name' => $request->input('bank_name'),
                'basic_salary' => $request->input('basic_salary'),
                'etf_number' => $request->input('etf_number'),
            ]);

            // Attach the category IDs to the staff member
            $staff->categories()->attach($request->input('category_ids'));

            // If the request wants JSON, return a JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff member created successfully.',
                    'data' => $staff
                ]);
            }

            // Redirect to the staff index page after successful creation
            return redirect()->route('staff.index')->with('success', 'Staff member created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create staff member: ' . $e->getMessage(), [
                'exception' => $e
            ]);
        
            // Handle any errors that occur during the process
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create staff member.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->route('staff.index')->with('error', 'Failed to create staff member.')->withInput();
        }
    }

    public function show($id, Request $request)
    {
        try {
            // Retrieve the staff member by ID with their associated categories
            $staff = Staff::with('categories')->find($id);

            // Check if the staff member exists
            if (!$staff) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Staff member not found.'
                    ], 404);
                }

                return view('pages.staff', ['staff' => null]);
            }

            // Format the result
            $result = [
                'id' => $staff->id,
                'name' => $staff->name,
                'contact_number' => $staff->contact_number,
                'ratings' => $staff->ratings,
                'categories' => $staff->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'image' => $category->image,
                    ];
                })
            ];

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            }

            // Return Blade view for a specific staff member
            return view('staff.show', compact('staff'));
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the staff member.',
                'error' => $e->getMessage() // Optionally include the exception message for debugging
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:15',
                'ratings' => 'required|integer|min:0|max:5',
                'category_ids' => 'nullable|array',
                'category_ids.*' => 'exists:categories,id', // Ensure each ID exists in the categories table
                'experience' => 'nullable|string|max:255',
                'join_date' => 'nullable|date',
                'bank_account_number' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'basic_salary' => 'nullable|numeric|min:0',
                'etf_number' => 'nullable|string|max:255',
            ]);

            // Find the staff member by ID
            $staff = Staff::find($id);

            // Check if the staff member exists
            if (!$staff) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Staff member not found.'
                    ], 404);
                }

                return redirect()->route('staff.index')->with('error', 'Staff member not found.');
            }

            // Update the staff member's details
            $staff->update([
                'name' => $request->input('name'),
                'contact_number' => $request->input('contact_number'),
                'ratings' => $request->input('ratings'),
                'experience' => $request->input('experience'),
                'join_date' => $request->input('join_date'),
                'bank_account_number' => $request->input('bank_account_number'),
                'bank_name' => $request->input('bank_name'),
                'basic_salary' => $request->input('basic_salary'),
                'etf_number' => $request->input('etf_number'),
            ]);

            // Sync the associated categories (this will update the pivot table)
            if ($request->has('category_ids')) {
                $staff->categories()->sync($request->input('category_ids'));
            }

            // If the request wants JSON, return a JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff member updated successfully.',
                    'data' => $staff
                ]);
            }

            // Redirect back to the staff index page after successful update
            return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
        } catch (\Exception $e) {
            // Handle any errors that occur during the process
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update staff member.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->route('staff.index')->with('error', 'Failed to update staff member. Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            // Find the staff member by ID
            $staff = Staff::find($id);

            // Check if the staff member exists
            if (!$staff) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Staff member not found.'
                    ], 404);
                }

                return redirect()->route('staff.index')->with('error', 'Staff member not found.');
            }

            // Detach associated categories (optional, as `delete` will handle this automatically)
            $staff->categories()->detach();

            // Delete the staff member
            $staff->delete();

            // If the request wants JSON, return a JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Staff member deleted successfully.'
                ]);
            }

            // Redirect back to the staff index page after successful deletion
            return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors that occur during the process
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete staff member.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->route('staff.index')->with('error', 'Failed to delete staff member.');
        }
    }
}
