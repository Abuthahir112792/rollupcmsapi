<nav class="navbar navbar-default navbar-fixed-top">
	<div class="brand" style="padding:0px 39px;">
		<a href="{{route('admin.home')}}"><img src="{{ \App\Helpers\Helper::getLogo('header') }}" alt="YouGo" class="img-responsive logo" style="height: 78px;width: 115px;"></a>
	</div>
	<div class="container-fluid">
		<div class="navbar-btn">
			<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-menu"></i></button>
		</div>
		<label class="switch">
          <input type="checkbox" class="order_allow" <?php echo (Auth::user()->order_allow == 1 ? ' checked' : '')?> >
          <span class="slider round"></span>
        </label>
        
        <div class="statusorder pull-left" id="statusorders" style="float: right;float: none;margin-top: 20px;margin-left: 200px;">
            <label >
            <input 
            style="display:none;background: #d63031;color:white;border: none;padding: 6px 12px;"
            type="button" class="neworder flash-button" value="New Pending/Cancelled Orders">
            </label>
		 </div>

        <div class="cus_alert_msg header-aleart"></div>

		<div id="navbar-menu">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('theme/assets/img/user.png')}}" class="img-circle" alt="Avatar"> <span>{{ \Illuminate\Support\Facades\Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
					</ul>
				</li>
			</ul>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
		</div>
	</div>
</nav>
