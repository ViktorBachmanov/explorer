<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

use App\Enums\Access as AccessEnum;
use App\Models\Folder;


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

        if ($request->user()->cannot('update', Folder::find($validated['parentFolderId']))) {
           abort(403, "You can't write into this folder");
        }

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

        $item->updateAccess($validated['userIdAccessFor'], $accessType, $accessValue);
    }

    public function rename(Request $request, string $items, int $itemId)
    {
        $validated = $request->validate([
            'newName' => 'required|string',
        ]);

        $itemClass = Relation::getMorphedModel($items);

        $item = $itemClass::find($itemId);

        Gate::authorize('rename', $item);

        $item->rename($validated['newName']);
    }
}
