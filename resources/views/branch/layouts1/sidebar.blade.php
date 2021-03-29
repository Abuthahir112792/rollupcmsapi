<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="{{route('branch.home')}}" class="{{ (( Request::segment(2)=='home' ? 'active' : '' )) }}" title="Dashboard"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
				
                <li class="orders-list-cls"><a href="{{route('branch.orders')}}" class="{{Request::segment(2)=='orders' ? 'active' : '' }}"><i class="lnr lnr-cart"></i> <span>Orders</span></a></li>

                <li class="orders-list-cls"><a href="{{route('branch.history')}}" class="{{Request::segment(2)=='history' ? 'active' : '' }}"><i class="lnr lnr-history"></i> <span>History</span></a></li>
                
			</ul>
		</nav>
	</div>
</div>
