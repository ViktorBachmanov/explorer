<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Gate;

use App\Enums\Access as AccessEnum;


class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $items)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'parentFolderId' => 'required|int',
        ]);

        $itemClass = Relation::getMorphedModel($items);

        $itemClass::createItem($validated['name'], $validated['parentFolderId']);

        return response()->json('Item has been created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function updateAccess(Request $request, string $items, int $itemId)
    {
        $validated = $request->validate([
            'userIdAccessFor' => 'required|integer',
            'access.type' => [Rule::enum(AccessEnum::class)],
            'access.value' => 'required|boolean',
        ]);

        if ($validated['userIdAccessFor'] === $request->user()->id) {
            abort(403, "You can't change access for yourself");
        }

        $accessType = AccessEnum::from($validated['access']['type']);
        $accessValue = $validated['access']['value'];

        $itemClass = Relation::getMorphedModel($items);

        $item = $itemClass::find($itemId);

        Gate::authorize('change-access', [$item, $accessType]);

        $affectedRows = $item->users()->updateExistingPivot($validated['userIdAccessFor'], [
            $accessType->value => $accessValue,
        ]);
      
        if ($affectedRows == 0) {
            $item->createAccess($validated['userIdAccessFor'], $accessType, $accessValue);
        }

    }
}
