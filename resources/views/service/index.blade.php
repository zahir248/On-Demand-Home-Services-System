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
                            <h5 class="mb-0">All Services</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button" data-bs-toggle="modal" data-bs-target="#createServiceModal">+&nbsp; New Service</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Provider</th> -->
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price (RM)</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Registration Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($services->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-xs font-weight-bold mb-0">No services available</td>
                                </tr>
                            @else
                                @foreach ($services as $service)
                                <tr>
                                    <td class="text-center text-xs font-weight-bold mb-0">{{ $service->id }}</td>
                                    <td class="text-center text-xs font-weight-bold mb-0">{{ $service->service_name }}</td>
                                    <!-- <td class="text-center text-xs font-weight-bold mb-0">{{ $service->provider->business_name ?? 'N/A' }}</td> -->
                                    <td class="text-center text-xs font-weight-bold mb-0">{{ number_format($service->price, 2) }}</td>
                                    <td class="text-center text-xs font-weight-bold mb-0">
                                        {{ $service->created_at ? $service->created_at->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-sm bg-{{ $service->status == 'active' ? 'success' : 'secondary' }} service-status-badge" 
                                            data-id="{{ $service->id }}" 
                                            data-status="{{ $service->status }}"
                                            style="cursor: pointer;" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#serviceStatusModal">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="mx-2 text-secondary show-service" data-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#serviceModal">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="mx-2 text-secondary edit-service" data-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#editServiceModal">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="mx-2 text-secondary delete-service" data-id="{{ $service->id }}" data-bs-toggle="modal" data-bs-target="#deleteServiceModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                        </table>
                        <div class="mt-3 mx-3">
                            {{ $services->links() }} <!-- Laravel pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('service.show')
@include('service.edit')
@include('service.delete')
@include('service.create')
@include('service.status')


@endsection