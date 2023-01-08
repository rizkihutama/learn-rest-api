<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryValidateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = CategoryResource::collection(Category::paginate());
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryValidateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValidateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = Category::create($request->validated());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage(), [], $e->getCode());
        }

        return $this->sendResponse($data, 'success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $result = new CategoryResource(Category::findOrFail($category->id_category));
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryValidateRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValidateRequest $request, Category $category)
    {
        DB::beginTransaction();
        try {
            $category->update($request->validated());
            $result = new CategoryResource($category);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage(), [], $e->getCode());
        }

        return $this->sendResponse($result, 'success', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
