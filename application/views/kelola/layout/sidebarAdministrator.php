<div class="main-container ace-save-state" id="main-container">
	<script type="text/javascript">
		try{ace.settings.loadState('main-container')}catch(e){}
	</script>

	<div id="sidebar" class="sidebar responsive ace-save-state">
		<script type="text/javascript">
			try{ace.settings.loadState('sidebar')}catch(e){}
		</script>
		
		<ul class="nav nav-list">
			<li class="active">
				<a href="<?php echo base_url();?>aparatur">
					<i class="menu-icon fa fa-tachometer"></i>
					<span class="menu-text"> Dashboard </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li>
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-road"></i>
					<span class="menu-text"> Manage Jalan</span>
					<b class="arrow fa fa-angle-down"></b>
				</a>
				<b class="arrow"></b>
				<ul class="submenu">
					<li class="">
						<a href="'.base_url().'laporan_masuk/"><i class="menu-icon fa fa-caret-right"></i>Data Jalan</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="'.base_url().'laporan_masuk/"><i class="menu-icon fa fa-caret-right"></i>Material Jalan</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="'.base_url().'laporan_masuk/"><i class="menu-icon fa fa-caret-right"></i>Kategori Jalan</a>
						<b class="arrow"></b>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-random"></i>
					<span class="menu-text"> Manage Jembatan</span>
					<b class="arrow fa fa-angle-down"></b>
				</a>
				<b class="arrow"></b>
				<ul class="submenu">
					<li class="">
						<a href="'.base_url().'laporan_masuk/"><i class="menu-icon fa fa-caret-right"></i>Data Jalan</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="'.base_url().'laporan_masuk/"><i class="menu-icon fa fa-caret-right"></i>Kategori Jalan</a>
						<b class="arrow"></b>
					</li>
				</ul>
			</li>	
			<li class=""><a href="'.base_url().'kelola/rekap_aduan/"><i class="menu-icon fa fa-users"></i> Manage User</a></li>			
		</ul>

		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
		</div>
	</div>