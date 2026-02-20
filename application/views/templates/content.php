<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0"><?php echo $page_title ?? 'Dashboard'; ?></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
						<?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
							<?php foreach ($breadcrumb as $crumb): ?>
								<li class="breadcrumb-item <?php echo $crumb['active'] ? 'active' : ''; ?>">
									<?php if (!$crumb['active']): ?>
										<a href="<?php echo $crumb['url']; ?>"><?php echo $crumb['title']; ?></a>
									<?php else: ?>
										<?php echo $crumb['title']; ?>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
							<li class="breadcrumb-item active"><?php echo $page_title ?? 'Dashboard'; ?></li>
						<?php endif; ?>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Content goes here -->
			<?php echo $content; ?>
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->