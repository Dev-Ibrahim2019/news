<div class="form-group">
    <x-form.input label="Category Name" type="text" name="name" id="name" :value="$category->name" role="input" />
</div>
<div class="form-group">
    <x-form.textarea label="Description" name="description" id="desc" :value="$category->description" />
</div>
<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" id="image" accept="image/*" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" width="100" height="100"
            class="m-3">
    @endif
</div>
<div class="form-group">
    <x-form.label>Status</x-form.label>
    <x-form.radio name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
</div>
<div class="form-group mb-0 mt-3 justify-content-end">
    <div>
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary ms-4">back</a>
    </div>
</div>
