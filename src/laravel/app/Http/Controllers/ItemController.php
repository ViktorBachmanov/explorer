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
    public function store(Request $request)
    {
        //
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
        $accessType = AccessEnum::from($validated['access']['type']);
        $accessValue = $validated['access']['value'];

        $itemClass = Relation::getMorphedModel($items);

        $item = $itemClass::find($itemId);

        // if (! Gate::allows('change-read-access', $item)) {
        //     abort(403);
        // }
        Gate::authorize('change-read-access', $item);

        $affectedRows = $item->users()->updateExistingPivot($validated['userIdAccessFor'], [
            $accessType->value => $accessValue,
        ]);
      
        if ($affectedRows == 0) {
            $item->createAccess($validated['userIdAccessFor'], $accessType, $accessValue);
        }

    }
}
