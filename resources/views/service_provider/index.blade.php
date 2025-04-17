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
                            <h5 class="mb-0">All Service Providers</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#createProviderModal">+&nbsp; New Provider</a>
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
                                        Business Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Owner
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Registration Date
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Approval Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($providers->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center text-xs font-weight-bold mb-0">
                                            No data available in table
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($providers as $provider)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $provider->id }}</p>
                                        </td>
                                        <td class="text-center">
                                            <div>
                                            <img src="{{ $provider->profile_picture && $provider->profile_picture !== 'default-avatar.png' 
                                                        ? asset('storage/' . $provider->profile_picture) 
                                                        : asset('assets/img/default-avatar.png') }}" 
                                                class="avatar avatar-sm me-3">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $provider->business_name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $provider->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $provider->address }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $provider->created_at->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-{{ 
                                                $provider->approval_status == 'approved' ? 'success' : 
                                                ($provider->approval_status == 'pending' ? 'warning' : 
                                                ($provider->approval_status == 'rejected' ? 'danger' : 'secondary')) 
                                            }} approval-status-badge" 
                                                data-id="{{ $provider->id }}" 
                                                data-status="{{ $provider->approval_status }}"
                                                style="cursor: pointer;" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#approvalStatusModal">
                                                {{ ucfirst($provider->approval_status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="mx-2 text-secondary show-provider" data-id="{{ $provider->id }}" data-bs-toggle="modal" data-bs-target="#providerModal">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <!-- Change the Edit button in the table to use a modal -->
                                            <a href="#" class="mx-2 text-secondary edit-provider" data-id="{{ $provider->id }}" data-bs-toggle="modal" data-bs-target="#editProviderModal">
                                                <i class="fas fa-user-edit"></i>
                                            </a>

                                            <a href="#" class="mx-2 text-secondary delete-provider" data-id="{{ $provider->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-original-title="Delete provider">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3 mx-3">
                            {{ $providers->links() }} <!-- Laravel pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('service_provider.create')
@include('service_provider.show')
@include('service_provider.edit')
@include('service_provider.delete')
@include('service_provider.approval_status')


@endsection