<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\SomeModel;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(SomeModel $someModel)
    {
        $images = $someModel->images;
        if ($images !== null) {
            usort($images, function($a, $b){
                return $a["index"] > $b["index"];
            });

            return $images;
        }

        return [];
    }

    public function store(SomeModel $someModel)
    {
        $validated = request()->validate([
            'image' => 'required|image|max:2048'
        ]);

        $filename = $validated["image"]->getClientOriginalName();
        $path = $validated["image"]->store('public/images/SomeModel/' . $someModel->id);

        $image = Image::create([
            'imagable_type' => 'App\\Models\\SomeModel',
            'imagable_id' => $someModel->id,
            'name' => $filename,
            'path' => $path
        ]);

        empty($someModel->images) ? $index = 1 : $index = max(array_column($someModel->images, 'index')) + 1;

        $imageStack = $someModel["images"] === null ? [] : $someModel["images"];

        array_push($imageStack, [
            'index' => $index,
            'image_id' => $image->id,
            'name' => $image->name,
            'path' => $image->path
        ]);

        $someModel["images"] = $imageStack;

        $someModel->save();

        return [
            'image_id' => $image->id,
            'name' => $image->name,
            'path' => $image->path,
            'index' => $index
        ];
    }

    public function update(SomeModel $someModel)
    {
        $validated = request()->validate([
            'imageStack' => 'required|array'
        ]);
        
        $newStack = [];
        $index = 1;

        foreach ($validated["imageStack"] as $image) {
            $newStack[] = [
                "name" => $image["name"],
                "path" => $image["path"],
                "index" => $index,
                "image_id" => $image["image_id"]
            ];
            $index++;
        }

        $someModel->images = $newStack;
        $someModel->save();

        return $newStack;
    }

    public function destroy(SomeModel $someModel, $index)
    {
        $imageStack = $someModel->images;

        $findIndex = array_search($index, array_column($imageStack, 'index'));
        // check if record exists. Indexes are numeric begins from 0.
        if (is_integer($findIndex)) {
            $willBeDeleted = $imageStack[$findIndex];
            unset($imageStack[$findIndex]);

            $image = Image::find($willBeDeleted["image_id"]);
            if ($image) {
                $image->delete();
            }

            Storage::delete($willBeDeleted["path"]);

            $someModel->images = $imageStack;
            $someModel->save();

            return response([], 204);
        }

        return response([], 422);
    }
}
