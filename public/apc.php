<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bootstrap</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">


	<!-- Le styles -->
	<link
		href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css"
		rel="stylesheet">
	<link
		href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css"
		rel="stylesheet">
	<link href="http://twitter.github.com/bootstrap/assets/css/docs.css"
		  rel="stylesheet">
	<link
		href="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css"
		rel="stylesheet">

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="assets/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144"
		  href="assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114"
		  href="assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72"
		  href="assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed"
		  href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">

<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse"
			   data-target=".nav-collapse"> <span class="icon-bar"></span> <span
					class="icon-bar"></span> <span class="icon-bar"></span>
			</a> <a class="brand" href="#">Project name</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#about">About</a></li>
					<li><a href="#contact">Contact</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle"
											data-toggle="dropdown">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li class="nav-header">Nav header</li>
							<li><a href="#">Separated link</a></li>
							<li><a href="#">One more separated link</a></li>
						</ul></li>
				</ul>
				<form class="navbar-form pull-right">
					<input class="span2" type="text" placeholder="Email"> <input
						class="span2" type="password" placeholder="Password">
					<button type="submit" class="btn">Sign in</button>
				</form>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>

<div class="container">

	<div class="row">
		<div class="span12">
			<h2>User</h2>

			<table class="table table-bordered table-condensed">
				<thead>
				<tr>
					<th>Key</th>
					<th>num_hits</th>
					<th>mem_size</th>
					<th>ttl</th>
					<th>mtime</th>
					<th>creation_time</th>
					<th>deletion_time</th>
					<th>access_time</th>
					<th>ref_count</th>
				</tr>
				</thead>
				<tbody>

				<?php foreach (  new APCIterator ( 'user' ) as $key => $value ): ?>
					<tr>
						<td><?php echo $key;?></td>
						<td><?php echo $value['num_hits'];?></td>
						<td><?php echo $value['mem_size'];?></td>
						<td><?php echo $value['ttl'];?></td>
						<td><?php echo $value['mtime'] - time();?></td>
						<td><?php echo $value['creation_time'] - time();?></td>
						<td><?php echo $value['deletion_time'];?></td>
						<td><?php echo $value['access_time'] - time();?></td>
						<td><?php echo $value['ref_count'];?></td>
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>

		</div>

	</div>

	<hr>

	<footer>
		<p>&copy; Company 2012</p>
	</footer>

</div>
<!-- /container -->

<?php
$api = new APCIterator ( 'file' );
var_dump ( $api->getTotalCount () );
var_dump ( $api->getTotalHits () );
var_dump ( $api->getTotalSize () );
foreach ( $api as $key => $value ) {
	var_dump ( $key, $value );
}
// var_dump ( apc_cache_info ('file') );
// var_dump ( apc_cache_info ('user') );
?>

<!-- Footer
================================================== -->
<footer class="footer">
	<div class="container">
		<p class="pull-right">
			<a href="#">Back to top</a>
		</p>
		<p>
			Designed and built with all the love in the world by <a
				href="http://twitter.com/mdo" target="_blank">@mdo</a> and <a
				href="http://twitter.com/fat" target="_blank">@fat</a>.
		</p>
		<p>
			Code licensed under <a
				href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache
				License v2.0</a>, documentation under <a
				href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.
		</p>
		<p>
			<a href="http://glyphicons.com">Glyphicons Free</a> licensed under <a
				href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.
		</p>
		<ul class="footer-links">
			<li><a href="http://blog.getbootstrap.com">Blog</a></li>
			<li class="muted">&middot;</li>
			<li><a href="https://github.com/twitter/bootstrap/issues?state=open">Issues</a></li>
			<li class="muted">&middot;</li>
			<li><a href="https://github.com/twitter/bootstrap/wiki">Roadmap and
					changelog</a></li>
		</ul>
	</div>
</footer>



<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript"
		src="http://platform.twitter.com/widgets.js"></script>
<script src="http://twitter.github.com/bootstrap/assets/js/jquery.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-alert.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-scrollspy.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tab.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-button.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-collapse.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-carousel.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/bootstrap-affix.js"></script>
<script
	src="http://twitter.github.com/bootstrap/assets/js/application.js"></script>

</body>
</html>