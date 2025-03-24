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
                            <h5 class="mb-0">All Customers</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#createCustomerModal">+&nbsp; New Customer</a>
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
                                        Image
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Registration Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($customers->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center text-xs font-weight-bold mb-0">
                                            No data available in table
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->id }}</p>
                                        </td>
                                        <td class="text-center">
                                            <div>
                                            <img src="{{ $customer->profile_picture !== 'default-avatar.png' 
                                                        ? asset('storage/' . $customer->profile_picture) 
                                                        : asset('assets/img/default-avatar.png') }}" 
                                                    class="avatar avatar-sm me-3">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->email }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $customer->created_at->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-2 text-secondary show-customer" data-id="{{ $customer->id }}" data-bs-toggle="modal" data-bs-target="#customerModal">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="mx-2 text-secondary edit-customer" data-id="{{ $customer->id }}" data-bs-toggle="modal" data-bs-target="#editCustomerModal">
                                                <i class="fas fa-user-edit"></i>
                                            </a>
                                            <a href="#" class="mx-2 text-secondary delete-customer" data-id="{{ $customer->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 mx-3">
                            {{ $customers->links() }} <!-- Laravel pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('customer.create')
@include('customer.show')
@include('customer.edit')
@include('customer.delete')


@endsection
