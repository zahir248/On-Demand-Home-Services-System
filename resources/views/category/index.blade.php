@extends('layouts.user_type.auth')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Service Categories</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#createCategoryModal">+&nbsp; New Category</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Description
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($categories->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-xs font-weight-bold mb-0">
                                            No data available in table
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $category->id }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $category->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $category->description }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-2 text-secondary edit-category" data-id="{{ $category->id }}" data-bs-toggle="modal" data-bs-target="#editCategoryModal">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="mx-2 text-secondary delete-category" data-id="{{ $category->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-original-title="Delete category">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 mx-3">
                            {{ $categories->links() }} <!-- Laravel pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('category.create')
@include('category.edit')
@include('category.delete')


@endsection
