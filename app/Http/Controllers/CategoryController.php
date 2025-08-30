<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
       // return $categories;
        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request)
//     {
//         $request->validate([
//         'name' => 'required|string|max:255',
//         'slug' => 'nullable|string|max:255',

//         'description' => 'nullable|string',
//         'image' => 'nullable|image|max:2048',
//         'status' => 'nullable|boolean',
//     ]);
//  $slug = Str::slug($request->name);
//     $category = new Category();
//     $category->name = $request->name;
//     $category->slug = $slug;

//     $category->description = $request->description;
//     $category->status = $request->has('status') ? 1 : 0;

//      if ($request->hasFile('image')) {
//             $file = $request->file('image');
//             $ext = $file->getClientOriginalExtension();
//             $filename = uniqid() . '.' . $ext;
//             $file->move('uploads/category/image/', $filename);
//             $category['image'] = 'uploads/category/image/' . $filename;
//         }
//    $status= $category->save();
//    if($status){
//  return response()->json([
//            'status' => true,
//             'message' => 'Category Save Successfully'
//         ]);
//    }


//     }

public function store(Request $request)
{
    $request->validate([
        'categories' => 'required|array',
        'categories.*.name' => 'required|string|max:255',
        'categories.*.description' => 'nullable|string',
        'categories.*.status' => 'nullable|boolean',
        'categories.*.image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    foreach ($request->categories as $index => $categoryData) {
        $category = new Category();

        $category->name = $categoryData['name'];
        $category->slug = Str::slug($categoryData['name']);
        $category->description = $categoryData['description'] ?? null;
        $category->status = isset($categoryData['status']) ? 1 : 0;

        // ✅ Fix: get file from request->file()
        if ($request->hasFile("categories.$index.image")) {
            $file = $request->file("categories.$index.image");
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/category/image/', $filename);
            $category->image = 'uploads/category/image/' . $filename;
        }

        $category->save();
    }

    return response()->json(['success' => true, 'message' => 'Categories saved successfully!']);
}

    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category,$slug)
    {
        $categories = Category::all();


      $category = Category::where('slug', $slug)->firstOrFail();
      return view('backend.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',

            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
        ]);
        $cat_id= $request->id;
       // return $cat_id;
        $category=Category::findOrFail($cat_id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;


         if ($request->hasFile('image')) {
            $destanation = $category->image;
            //return  $destanation;
            if (File::exists($destanation)) {
                File::delete($destanation);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $ext;
            $file->move('uploads/category/image/', $filename);
            $category['image'] = 'uploads/category/image/' . $filename;
        } else {
            $category->image = $category->image;
        }

       $status = $category->update();
       if($status){
 return response()->json([
            'status' => true,
            'message' => 'Category Update Successfully'
        ]);
       }


    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy( $id)
    {
        $category=Category::findOrFail($id);
        $category->delete();
      //  toast(' Deleted Successfully!', 'success');
         return response()->json([
            'status' => true,
            'message' => 'Category Delete Successfully'
        ]);
    }
public function statusUpdate(Request $request)
{
    $category = Category::findOrFail($request->id);
    $category->status = $request->status;
    $category->save();

    return response()->json([
        'success' => true,
        'status' => $category->status
    ]);
}
}
