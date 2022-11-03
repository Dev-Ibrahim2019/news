<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" id="image" accept="image/*" />
    @if ($news->image)
        <img src="{{ asset('storage/' . $news->image) }}" alt="" width="100" height="100"
            class="m-3">
    @endif
</div>
<div class="form-group">
    <x-form.input label="Title" type="text" name="title" id="title" :value="$news->title" role="input" />
</div>
<div class="form-group">
    <x-form.label id="category_id">Category</x-form.label>
    <select name="category_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach (App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $news->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea label="Description" name="description" id="desc" :value="$news->description" />
</div>
<div class="form-group">
    <x-form.label id="demo">Content Images </x-form.label>
    <div>
        <x-form.input type="file" id="images" name="news_images[]" data-height="200" multiple="" />
    </div>
</div>
<div class="form-group">
    <x-form.label>Status</x-form.label>
    <x-form.radio name="status" :checked="$news->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
</div>
<div class="form-group mb-0 mt-3 justify-content-end">
    <div>
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary ms-4">back</a>
    </div>
</div>
