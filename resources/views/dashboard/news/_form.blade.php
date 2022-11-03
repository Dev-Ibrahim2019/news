<div class="form-group">
    <x-form.label id="image">Main Image </x-form.label>
    <x-form.input type="file" name="image" id="image" accept="image/*" />
    @if ($news->image)
        <img src="{{ asset('storage/' . $news->image) }}" alt="" width="100" height="100" class="m-3">
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
        <form action="" class="dropzone">
            <x-form.input type="file" id="images" name="news_images[]" data-height="200" multiple="" />
        </form>

        {{-- <x-form.input type="file" name="news_images[]" id="demo" class="dropify"
            accept=".jpg, .png, image/jpeg, image/png, html, zip, css,js" multiple="" class="ff_fileupload_hidden" /> --}}
    </div>
</div>
<div class="form-group">
    <x-form.label>Status</x-form.label>
    <x-form.radio name="status" :checked="$news->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
</div>
<div class="form-group mb-0 mt-3 justify-content-end">
    <div>
        <button type="submit" class="btn btn-primary">save</button>
        {{-- <sub type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</sub> --}}
        <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary ms-4">back</a>
    </div>
</div>


{{-- @push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@endpush --}}

@push('scripts')
    <!--Internal Fileuploads js-->
    <script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

    <!--Internal Fancy uploader js-->
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    {{-- <script>
        const inputElement = document.querySelector('input[id="images"]');
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            server: 'uploads/'
        });
    </script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script> --}}
@endpush
