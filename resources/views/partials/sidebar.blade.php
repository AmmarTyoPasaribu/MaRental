<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: rgb(58,93,139);
background: linear-gradient(270deg, rgba(58,93,139,1) 0%, rgba(90,46,101,1) 100%);">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">MaRental <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{route('admin.dashboard.index')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<li class="nav-item active">
    <a class="nav-link" href="{{route('admin.cars.index')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Car List</span></a>
</li>

<hr class="sidebar-divider">

<li class="nav-item active">
    <a class="nav-link" href="{{route('admin.drivers.index')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Driver List</span></a>
</li>

<hr class="sidebar-divider">

<li class="nav-item active">
    <a class="nav-link" href="{{route('admin.bayars.index')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Payment</span></a>
</li>

<hr class="sidebar-divider">

<li class="nav-item active">
    <a class="nav-link" href="{{route('admin.users.index')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>User Profile</span></a>
</li>

<li class="nav-item active">
    <a class="nav-link" onclick="document.getElementById('logout-form').submit()" href="#">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
  <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
</svg>
        <span>  Log Out</span></a>
        <form id="logout-form" action="{{ route('logout') }}"method="post">
            @csrf
        </form>
</li>

</ul>


































<!-- Nav Item - Pages Collapse Menu -->



<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
        </div>
    </div>
</li>

</ul> -->