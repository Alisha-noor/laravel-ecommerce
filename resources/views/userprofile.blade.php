 @extends('layouts.app')

 @section('content')
     <!-- ✅ Welcome Banner -->
     <div class="welcome-banner text-center py-5 mb-5">
         <div class="avatar-wrapper mb-3" style="position: relative; display: inline-block;">

             <!-- Avatar upload form -->
             <form action="{{ route('user.update.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                 @csrf
                 <label for="avatarInput" class="avatar-label">
                     @if ($user->avatar ?? false)
                         <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" class="profile-avatar">
                     @else
                         <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=b56576&color=fff&size=120"
                             alt="Default Avatar" class="profile-avatar">
                     @endif
                     <div class="avatar-overlay">Change</div>
                 </label>
                 <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;"
                     onchange="document.getElementById('avatarForm').submit();">
             </form>

             <!-- ✅ Delete form OUTSIDE the upload form -->
             @if ($user->avatar ?? false)
                 <form action="{{ route('profile.removeAvatar') }}" method="POST" class="avatar-delete-form">
                     @csrf
                     <button type="submit" class="avatar-delete-btn">🗑</button>
                 </form>
             @endif

         </div>

         <h2 class="mb-1">Welcome, {{ $user->name }} 👋</h2>
         <p class="mb-0">Here you can manage your profile and shipping details</p>
     </div>

     <div class="container my-5">
         <h2 class="mb-4 fw-bold text-center profile-heading">My Profile</h2>

         <div class="row">
             <!-- User Info -->
             <div class="col-md-6 mb-4">
                 <div class="card profile-card shadow-sm">
                     <div class="card-header">
                         <h5 class="mb-0">Account Information</h5>
                     </div>
                     <div class="card-body">
                         <p><strong>Name:</strong> {{ $user->name }}</p>
                         <p><strong>Email:</strong> {{ $user->email }}</p>
                         <a href="{{ route('usereditprofile') }}" class="btn btn-custom mt-2">
                             Edit Profile
                         </a>
                     </div>
                 </div>
             </div>

             <!-- Address Info -->
             <div class="col-md-6 mb-4">
                 <div class="card profile-card shadow-sm">
                     <div class="card-header">
                         <h5 class="mb-0">Shipping Address</h5>
                     </div>
                     <div class="card-body">
                         @if ($address)
                             <p><strong>Full Name:</strong> {{ $address->name }}</p>
                             <p><strong>Phone:</strong> {{ $address->phone }}</p>
                             <p><strong>Street:</strong> {{ $address->address }}</p>
                             <p><strong>Locality:</strong> {{ $address->locality }}</p>
                             <p><strong>Landmark:</strong> {{ $address->landmark ?? 'N/A' }}</p>
                             <p><strong>City:</strong> {{ $address->city }}</p>
                             <p><strong>State:</strong> {{ $address->state }}</p>
                             <p><strong>ZIP Code:</strong> {{ $address->zip }}</p>

                             <a href="{{ route('addressedit', $address->id) }}" class="btn btn-custom mt-2">
                                 Edit Address
                             </a>
                             <form action="{{ route('address.delete', $address->id) }}" method="POST"
                                 style="display:inline;">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" class="btn btn-danger-custom mt-2"
                                     onclick="return confirm('Are you sure you want to delete this address?');">
                                     Delete Address
                                 </button>
                             </form>
                         @else
                             <p class="text-muted">No address saved yet.</p>
                             <a href="{{ route('cart.checkout') }}" class="btn btn-outline-custom">Add Address</a>
                         @endif

                         @if (session('success'))
                             <div class="alert alert-success mt-3">
                                 {{ session('success') }}
                             </div>
                         @endif
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <style>
         /* ✅ Welcome Banner */
         .welcome-banner {
             background: #b56576;
             color: #fff;
             border-radius: 12px;
             font-family: 'Playfair Display', serif;
             position: relative;
         }

         .welcome-banner h2 {
             font-weight: 700;
         }

         .welcome-banner p {
             font-size: 1rem;
             opacity: 0.9;
         }

         /* Avatar Styling */
         .avatar-wrapper {
             display: flex;
             justify-content: center;
             position: relative;
         }

         .avatar-label {
             position: relative;
             cursor: pointer;
             display: inline-block;
         }

         .profile-avatar {
             width: 120px;
             height: 120px;
             border-radius: 50%;
             border: 4px solid #fff;
             object-fit: cover;
             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
             transition: transform 0.3s ease;
         }

         .profile-avatar:hover {
             transform: scale(1.05);
         }

         .avatar-overlay {
             position: absolute;
             bottom: 0;
             left: 0;
             right: 0;
             background: rgba(0, 0, 0, 0.6);
             color: #fff;
             font-size: 0.9rem;
             text-align: center;
             padding: 5px;
             border-radius: 0 0 50% 50%;
             opacity: 0;
             transition: opacity 0.3s ease;
         }

         .avatar-label:hover .avatar-overlay {
             opacity: 1;
         }

         /* Profile Heading */
         .profile-heading {
             font-family: 'Playfair Display', serif;
             color: #b56576;
             border-bottom: 2px solid #b56576;
             display: inline-block;
             padding-bottom: 5px;
         }

         /* Card Styling */
         .profile-card {
             border: none;
             border-radius: 12px;
             transition: transform 0.2s ease, box-shadow 0.2s ease;
         }

         .profile-card:hover {
             transform: translateY(-3px);
             box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
         }

         /* Card Header */
         .card-header {
             font-weight: 600;
             color: #b56576;
             background-color: #f9f3f4;
             border-bottom: 2px solid #b56576;
             border-radius: 12px 12px 0 0 !important;
         }

         .btn-danger-custom {
             background-color: #dc3545;
             color: #fff;
             border: none;
             border-radius: 6px;
             padding: 6px 14px;
             transition: 0.3s ease;
         }

         .btn-danger-custom:hover {
             background-color: #b52d39;
             color: #fff;
         }

         /* Custom Buttons */
         .btn-custom {
             background-color: #b56576;
             color: #fff;
             border: none;
             border-radius: 6px;
             padding: 6px 14px;
             transition: 0.3s ease;
         }

         .btn-custom:hover {
             background-color: #9d4d62;
             color: #fff;
         }

         .btn-danger-custom {
             background-color: #dc3545;
             color: #fff;
             border: none;
             border-radius: 6px;
             padding: 6px 14px;
             transition: 0.3s ease;
         }

         .btn-danger-custom:hover {
             background-color: #b52d39;
             color: #fff;
         }

         .btn-outline-custom {
             border: 2px solid #b56576;
             color: #b56576;
             border-radius: 6px;
             padding: 6px 14px;
             transition: 0.3s ease;
         }

         .btn-outline-custom:hover {
             background-color: #b56576;
             color: #fff;
         }

         /* Hide trash icon by default */
         .avatar-delete-btn {
             position: absolute;
             top: 5px;
             right: 5px;
             background: rgba(251, 246, 247, 0.9);
             /* red background */
             color: black;
             border: none;
             border-radius: 50%;
             padding: 6px;
             font-size: 16px;
             cursor: pointer;
             opacity: 0;
             transition: opacity 0.3s ease;
         }

         /* Show trash icon on avatar hover */
         .avatar-wrapper:hover .avatar-delete-btn {
             opacity: 1;
         }

         /* Optional hover effect on trash button */
         .avatar-delete-btn:hover {
             background: #df707a;
         }
     </style>
 @endsection
