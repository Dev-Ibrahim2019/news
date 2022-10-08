<div class="form-group">
    <x-form.input label="Title" type="text" name="title" id="title" :value="$news->title" role="input" />
</div>
<div class="form-group">
    <x-form.label id="category_id">Category</x-form.label>
    <select name="category_id" class="form-control form-select">
        <option value="">Primary Category</option>
        {{-- @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach --}}
        {{-- @foreach ($news->category()->with('category') as $news)
            <option value="{{ $news->id }}" @selected(old('category_id', $news->category_id) == $news->id)>{{ $news->name }}</option>
        @endforeach --}}
        @foreach ($category_news as $_news)
            <option value="{{ $_news->category_id }}" @selected(old('category_id', $_news->category_id) == $_news->id)>{{ $_news->category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea label="Description" name="description" id="desc" :value="$news->description" />
</div>
<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    <x-form.input type="file" name="image" id="image" accept="image/*" />
    @if ($news->image)
        <img src="{{ asset('storage/' . $news->image) }}" alt="" width="100" height="100"
            class="m-3">
    @endif
</div>
<div class="form-group mb-0 mt-3 justify-content-end">
    <div>
        <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
        <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary ms-4">back</a>
    </div>
</div>
