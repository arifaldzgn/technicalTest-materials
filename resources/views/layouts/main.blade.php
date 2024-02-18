<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css'>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <!-- Include jQuery library -->
  <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Include DataTables library -->
  <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script defer src="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css"></script>
  <script defer src="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="/css/style.css">
</head>

@if (Route::currentRouteName() === 'login')
@else
<body>
<div id="sidebar-overlay" class="overlay w-100 vh-100 position-fixed d-none"></div>
<!-- Sidebar -->
<div class="col-md-3 col-lg-2 px-0 position-fixed h-100 bg-white shadow-sm sidebar" id="sidebar">
  <h1 class="bi bi-app-indicator text-primary d-flex my-4 justify-content-center"></h1>
  <div class="list-group rounded-0">
    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active border-0 d-flex align-items-center">
      <span class="bi bi-border-all"></span>
      <span class="ml-2">Dashboard</span>
    </a>

    <button class="list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#sale-collapse">
      <div>
        <span class="bi bi-box"></span>
        <span class="ml-2">Material Requests</span>
      </div>
      <span class="bi bi-chevron-down small"></span>
    </button>
    <div class="collapse" id="sale-collapse" data-parent="#sidebar">
      <div class="list-group">
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action border-0 pl-5">All</a>
        <a href="{{ route('pending') }}" class="list-group-item list-group-item-action border-0 pl-5">Pending/Incoming</a>
        <a href="{{ route('approved') }}" class="list-group-item list-group-item-action border-0 pl-5">Approved</a>
        <a href="{{ route('rejected') }}" class="list-group-item list-group-item-action border-0 pl-5">Rejected</a>
      </div>
    </div>
    <a href="#" class="list-group-item list-group-item-action border-0 align-items-center">
      <span class="bi bi-arrow-clockwise"></span>
      <span class="ml-2">History</span>
    </a>
  </div>
</div>

<div class="col-md-9 col-lg-10 ml-md-auto px-0 ms-md-auto">
  <!-- Top nav -->
  <nav class="w-100 d-flex px-4 py-2 mb-4 shadow-sm">
    <button class="btn py-0 d-lg-none" id="open-sidebar">
      <span class="bi bi-list text-primary h3"></span>
    </button>
    <div class="dropdown ml-auto">
      <button class="btn py-0 d-flex align-items-center" id="logout-dropdown" data-toggle="dropdown" aria-expanded="false">
        <span class="bi bi-person text-primary h4"></span>
        <span class="bi bi-chevron-down ml-1 mb-2 small"></span>
      </button>
      <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm" aria-labelledby="logout-dropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">Settings</a>
        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
      </div>
    </div>
  </nav>
@endif

@yield('container')
    
</body>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js'></script>

<script  src="/script/dashboard.js"></script>
</html>
</html>