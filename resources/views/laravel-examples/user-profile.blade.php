@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        {{-- Added id="profile_avatar_img" for JS preview --}}
                        <img 
                        src="{{ $user->profile_picture && $user->profile_picture !== 'default-avatar.png' 
                            ? asset('storage/' . $user->profile_picture) 
                            : asset('assets/img/default-avatar.png') }}" 
                            class="w-100 border-radius-lg shadow-sm">
                        {{-- Added id="edit_picture_button" to the link --}}
                        <a href="javascript:;" id="edit_picture_button" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                            <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                        </a>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->name }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Profile Information') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                {{-- Keep enctype for file uploads (triggered by hidden input) --}}
                <form action="/profile" method="POST" role="form text-left" enctype="multipart/form-data">
                    @csrf

                    {{-- Hidden input field for profile picture --}}
                    {{-- This will be triggered by the edit icon via JavaScript --}}
                    <input type="file" name="profile_picture" id="profile_picture_input" style="display: none;" accept="image/*">
                     @error('profile_picture')
                        {{-- Display file upload errors (e.g., size, type) --}}
                         <div class="mt-0 mb-3 alert alert-danger alert-dismissible fade show" role="alert">
                             <span class="alert-text text-white">
                             {{ $message }}</span>
                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                 <i class="fa fa-close" aria-hidden="true"></i>
                             </button>
                         </div>
                     @enderror


                    @if($errors->any() && !$errors->has('profile_picture')) {{-- Avoid showing generic error if it's just the profile pic error shown above --}}
                        <div class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            Please fix the errors below. {{-- $errors->first() --}} </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3 alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Field: Name --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-name" class="form-control-label">{{ __('Full Name') }}</label>
                                <div class="@error('name')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ old('name', auth()->user()->name) }}" type="text" placeholder="-" id="user-name" name="name">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Field: Email --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                <div class="@error('email')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ old('email', auth()->user()->email) }}" type="email" placeholder="-" id="user-email" name="email">
                                        @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Field: Phone --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Phone') }}</label>
                                <div class="@error('phone')border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="tel" placeholder="-" id="number" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}">
                                        @error('phone')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                         @if(auth()->user()->role === 'provider')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.business_name" class="form-control-label">{{ __('Business Name') }}</label>
                                <div class="@error('business_name') border border-danger rounded-3 @enderror">
                                    <input class="form-control" type="text" placeholder="-" id="business_name" name="business_name" value="{{ old('business_name', auth()->user()->business_name ?? '') }}">
                                     @error('business_name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Field: Address --}}
                    <div class="row">
                         <div class="col-md-12">
                            <div class="form-group">
                                <label for="user.address" class="form-control-label">{{ __('Full Address') }}</label>
                                <div class="@error('address') border border-danger rounded-3 @enderror">
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="-">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                                    @error('address')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Removed the visible profile picture upload field --}}

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the elements
        const editButton = document.getElementById('edit_picture_button');
        const fileInput = document.getElementById('profile_picture_input');
        const profileImage = document.getElementById('profile_avatar_img');

        // Check if elements exist before adding listeners
        if (editButton && fileInput) {
            // Add click listener to the edit button
            editButton.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default anchor behavior
                fileInput.click(); // Trigger click on the hidden file input
            });
        }

        if (fileInput && profileImage) {
            // Add change listener to the file input
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0]; // Get the selected file

                if (file) {
                    // Use FileReader to read the file and generate a preview
                    const reader = new FileReader();

                    reader.onload = function(event) {
                        // Set the src of the profile image to the preview URL
                        profileImage.src = event.target.result;
                    }

                    // Read the file as a Data URL (base64 encoded string)
                    reader.readAsDataURL(file);
                }
            });
        }

        // Initialize Bootstrap tooltips (if not already done elsewhere)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })

    });
</script>

@endsection