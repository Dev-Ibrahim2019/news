@extends('layouts.dashboard')
@section('title', 'Categories')
@section('breadcrumb')
    @parent
    <span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Category</span>
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Category List</h3>
                    <div class="d-flex">
                        <a class="btn btn-primary text-light mx-3" href="{{ route('dashboard.categories.create') }}">Create
                            Category</a>
                        <a class="btn btn-danger text-light" href="{{ route('dashboard.categories.trash') }}">Trash</a>
                    </div>
                </div>
                <form action="{{ URL::current() }}" method="GET" class="d-flex justify-content-betweem m-4">
                    <x-form.input name="name" placeholder="Name" :value="request('name')" />
                    <select name="status" class="form-select mx-3">
                        <option value="">All</option>
                        <option value="active" @selected(request('status') == 'active')>Active</option>
                        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
                    </select>
                    <button class="btn btn-dark">Filter</button>
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th class="wd-10p"></th>
                                    <th class="wd-5p">ID</th>
                                    <th class="wd-20p">Name</th>
                                    <th class="wd-10p">Status</th>
                                    <th class="wd-20p">Created At</th>
                                    <th class="wd-10p"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $category->image) }}" alt=""
                                                height="50px" width="70px" class="rounded">
                                        </td>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td><span
                                                class="badge bg-{{ $category->status == 'active' ? 'success' : 'danger' }} me-1">{{ $category->status }}</span>
                                        </td>
                                        <td>{{ $category->created_at }}</td>
                                        <td name="bstable-actions">
                                            <div class="btn-list d-flex">
                                                <a id="bEdit"
                                                    href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-primary mx-3">
                                                    <span class="fe fe-edit"> </span>
                                                </a>
                                                <form action="{{ route('dashboard.categories.destroy', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    {{-- method spoofing --}}
                                                    @method('DELETE')
                                                    <button id="bDel" type="submit" class="btn btn-sm btn-danger">
                                                        <span class="fe fe-trash-2"> </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">No Categories Defined</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
