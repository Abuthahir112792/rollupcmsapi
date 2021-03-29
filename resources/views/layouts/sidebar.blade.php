<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="{{route('admin.home')}}" class="{{ (( Request::segment(2)=='home' ? 'active' : '' )) }}" title="Dashboard"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
				
                <li class="user-list-cls"><a href="{{route('admin.users')}}" class="{{Request::segment(2)=='users' ? 'active' : '' }}"><i class="lnr lnr-users"></i> <span>Users</span></a></li>

                <li class="cms-list-cls"><a href="{{route('admin.cms')}}" class="{{Request::segment(2)=='cms' ? 'active' : '' }}"><i class="fa fa-folder-o" aria-hidden="true"></i> <span>CMS</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.category')}}" class="{{Request::segment(2)=='category' ? 'active' : '' }}"><i class="lnr lnr-store"></i> <span>Category</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.product')}}" class="{{Request::segment(2)=='product' ? 'active' : '' }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span>Product</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.orders')}}" class="{{Request::segment(2)=='orders' ? 'active' : '' }}"><i class="lnr lnr-cart"></i> <span>Orders</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.history')}}" class="{{Request::segment(2)=='history' ? 'active' : '' }}"><i class="lnr lnr-history"></i> <span>History</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.branchmanage')}}" class="{{Request::segment(2)=='branchmanage' ? 'active' : '' }}"><i class="lnr lnr-diamond"></i> <span>BranchManage</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.adminfeedback')}}" class="{{Request::segment(2)=='adminfeedback' ? 'active' : '' }}"><i class="lnr lnr-pencil"></i> <span>Feedback</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.referral')}}" class="{{Request::segment(2)=='referral' ? 'active' : '' }}"><i class="lnr lnr-user"></i> <span>Referral Friends</span></a></li>

                <!-- <li class="orders-list-cls"><a href="{{route('admin.statuslist')}}" class="{{Request::segment(2)=='statuslist' ? 'active' : '' }}"><i class="lnr lnr-highlight"></i> <span>Status List</span></a></li> -->
			</ul>
		</nav>
	</div>
</div>
