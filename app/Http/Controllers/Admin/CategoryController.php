<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно создана');
    }

    public function show(string $id)
    {
        $category = Category::with(['parent', 'children'])->findOrFail($id);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::where('id', '!=', $id)->orderBy('name')->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория обновлена');
    }

    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория удалена');
    }
}
