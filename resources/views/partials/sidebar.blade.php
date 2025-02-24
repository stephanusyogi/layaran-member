<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme border-end">
    <div class="app-brand demo">
      <a href="{{ route('dashboard') }}" class="app-brand-link">
        <span class="app-brand-logo demo">
          <img style="width: 60px" src="{{ asset('assets/images/logo-1.png') }}" alt="logo-layaran">
        </span>
        <span class="app-brand-text demo menu-text fw-bolder">Live Chat</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3">
      <li class="menu-item my-2 {{ Request::is('/*') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>
      <li class="menu-item my-2">
        <a href="javascript:void(0)" class="menu-link">
          <i class="menu-icon tf-icons bx bx-calendar-event"></i>
          <div data-i18n="Events">Events</div>
        </a>
      </li>
      <li class="menu-item my-2  {{ Request::is('billings*') ? 'active' : '' }}">
        <a href="{{ route('billings') }}" class="menu-link">

          <i class="menu-icon tf-icons bx bx-receipt"></i>
          <div data-i18n="Billings">Billings</div>
        </a>
      </li>
      @role('admin')
      <li class="menu-item my-2 {{ Request::is('announcements*') ? 'active' : '' }}">
        <a href="{{ route('announcements') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bell"></i>
          <div data-i18n="Announcements">Announcements</div>
        </a>
      </li>
      <li class="menu-item my-2 {{ Request::is('members*') ? 'active' : '' }}">
        <a href="{{ route('members') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div data-i18n="Members">Members</div>
        </a>
      </li>
      <li class="menu-item my-2 {{ Request::is('administrators*') ? 'active' : '' }}">
        <a href="{{ route('administrators') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user-check"></i>
          <div data-i18n="Members">Administrators</div>
        </a>
      </li>
      @endrole
      <li class="menu-item mt-auto mb-4 {{ Request::is('manage_subscriptions*') ? 'active' : '' }}">
          <a href="{{ route('manage_subscriptions') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-wallet"></i>
              <div data-i18n="Manage Subscription">Manage Subscription</div>
          </a>
      </li>
    </ul>
</aside>