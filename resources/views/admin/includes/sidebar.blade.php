<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ asset(Auth::user()->profile->avatar)}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>BlogApp</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(Auth::user()->profile->avatar)}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a>{{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" class="nav-link {{ (request()->is('admin/home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index')}}" class="nav-link {{ (request()->is('admin/users*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ (request()->is('admin/categories*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Categories
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tags.index') }}" class="nav-link {{ (request()->is('admin/tags*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Tags
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('posts') }}" class="nav-link {{ (request()->is('admin/posts*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clone"></i>
                        <p>
                            Published Posts
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('news.index') }}" class="nav-link {{ (request()->is('admin/news*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            News Posts
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('trashed.post')}}" class="nav-link {{ (request()->is('admin/trashed/posts*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trash"></i>
                        <p>
                            Trashed Post
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('subscribers.index')}}" class="nav-link {{ (request()->is('admin/subscriber*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Subscriber
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('settings')}}" class="nav-link {{ (request()->is('admin/setting*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('inbox')}}" class="nav-link {{ (request()->is('admin/inbox*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>
                            Message / Inbox
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.profile')}}" class="nav-link {{ (request()->is('admin/user/profile*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            My Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-power-off"></i>
                        <p> {{ __('Logout') }}</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>