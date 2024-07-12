<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu mt-3">
            <div class="nav">
                <a class="nav-link {{Request::is('admin/dashboard')?'active':''}}" href="{{route('admin.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            </div>
            <div class="nav">
                <a class="nav-link {{Request::is('questions*')?'active':''}}" href="{{ route('questions.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Questions
                </a>
            </div>
            <div class="nav">
                <a class="nav-link {{Request::is('feedbacks*')?'active':''}}" href="{{ route('userfeedback.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Feedbacks
                </a>
            </div>
			<hr/>
			<div class="nav">
                <a class="nav-link" href="{{ route('logout') }}"
				 onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Logout
                </a>
				  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:   {{ auth()->user()->name }}</div>
          
        </div>
    </nav>
</div>