<?php

namespace App\Http\Controllers\API;

use App\Models\FamilyTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FamilyTreeAPIController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familyTreeData = FamilyTree::all();

        return response()->json(['family_tree' => $familyTreeData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'name' => "required",
                'birth_date' => "required",
                'gender' => "required|in:male,female",
                'parent_id' => "required",
            ]);

            $person = FamilyTree::create($validatedData);
            return response()->json(['message' => 'Person created successfully', 'data' => $person], 201);

        } catch (ValidationException $e) {
            // If validation fails, return message the validation errors
            throw new HttpResponseException(response(['errors' => $e->validator->getMessageBag()], 400));

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create FamilyTree', 'message' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyTree $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $familyTree = FamilyTree::findOrFail($id);

            $validatedData = $this->validate($request, [
                'name' => "required",
                'birth_date' => "required",
                'gender' => "required|in:male,female",
                'parent_id' => "required",
            ]);

            $familyTree->update($validatedData);
            return response()->json(['message' => 'Person update successfully', 'data' => $familyTree], 201);

        } catch (ValidationException $e) {
            // If validation fails, return message the validation errors
            throw new HttpResponseException(response(['errors' => $e->validator->getMessageBag()], 400));
        } catch (ModelNotFoundException $e) {
            // if id  or person not found return 
            return response()->json(['errors' => ['message' => ['Person not found']]], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update FamilyTree', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $familyTree = FamilyTree::findOrFail($id);
            $familyTree->delete();

            return response()->json(['message' => 'Person deleted successfully'], 20);

        } catch (ModelNotFoundException $e) {
            // if id  or person not found return 
            return response()->json(['errors' => ['message' => ['Person not found']]], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to deleted FamilyTree', 'message' => $e->getMessage()], 500);
        }
    }

    public function getChildById(Request $request, $parentId)
    {
        $gender = $request->input('gender');
        $familyTrees = FamilyTree::with([
            'children' => function ($query) use ($gender) {
                if ($gender !== null) {
                    $query->where('gender', $gender); // get children by gender
                }
            }
        ])
            ->where('id', $parentId)
            ->get();

        return response()->json(['data' => $familyTrees], 200);
    }

    public function getGrandChildById(Request $request, $grandParentId)
    {
        $gender = $request->input('gender');

        // Get grandchildren
        $grandchildren = FamilyTree::whereIn('parent_id', function ($query) use ($grandParentId) {
            $query->select('id')
                ->from('family_tree')
                ->where('parent_id', $grandParentId);
        })
            ->when($gender !== null, function ($query) use ($gender) {
                $query->where('gender', $gender); // get children by gender
            })
            ->get();

        // Get grandparents
        $grandparents = FamilyTree::where('id', $grandParentId)
            ->first();

        $result = [
            'id' => $grandparents->id,
            'name' => $grandparents->name,
            'birth_date' => $grandparents->birth_date,
            'gender' => $grandparents->gender,
            'grandchildren' => $grandchildren->toArray(),
        ];

        return response()->json(['data' => $result], 200);
    }

    public function getAuntByNephewName($childName)
    {
        // Get the child data
        $child = FamilyTree::where('name', $childName)->first();

        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        // Get the parent data
        $childParent = FamilyTree::find($child->parent_id);

        // Get all siblings of the parent
        $parentSiblings = FamilyTree::where('parent_id', $childParent->parent_id)
            ->where('id', '<>', $childParent->id) // Exclude the parent itself
            ->where('gender', 'female') // Filter by female gender
            ->get();

        return response()->json(['parentSiblings' => $parentSiblings], 200);
    }

    public function getCousinByCousinName(Request $request, $childName)
    {
        $gender = $request->input('gender');

        //  Get the child data
        $child = FamilyTree::where('name', $childName)->first();

        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        // Get the parent data
        $childParent = FamilyTree::find($child->parent_id);

        if (!$childParent) {
            return response()->json(['error' => 'Parent not found'], 404);
        }

        // Get the parent's siblings
        $parentSiblings = FamilyTree::where('parent_id', $childParent->parent_id)
            ->where('id', '<>', $childParent->id) // Exclude the parent itself
            ->get();
        $parentSiblingIds = $parentSiblings->pluck('id');

        // get cousins
        $cousins = FamilyTree::whereIn('parent_id', $parentSiblingIds);
        if ($gender !== null) {
            $cousins->where('gender', $gender);
        }

        $cousins = $cousins->get();

        return response()->json(['cousins' => $cousins], 200);
    }
}
