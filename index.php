<?php
include("config/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>IATI Explorer Toolkit</title>
	<link rel="stylesheet" type="text/css" media="all" href="/css/style.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="all" href="/css/style-ie.css" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="all" href="/css/custom.css" />
	<link rel="stylesheet" type="text/css" media="all" href="/css/iati-toolkit.css" />	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 	
	<script type="text/javascript" src="/js/display.js"></script> 

</head>
<body>
	<div id="wrapper" class="hfeed">
		<div id="header">
			<div id="masthead" class="clearfix">
				<div id="branding" role="banner">
	            	<img src="/images/iati-toolkit-logo-draft.png" border="0" />
	                <div id="site-description">a collection of tools for working with IATI Data</div>
	            </div><!-- #branding -->

				<div id="access" class="access clearfix" role="navigation">
				  				<div class="skip-link screen-reader-text"><a href="#content" title="Skip to content">Skip to content</a></div>
									<div class="menu"><?php include("includes/menu.inc.php"); ?></div>			</div><!-- #access -->
			</div><!-- #masthead -->
		</div><!-- #header -->
	
	
		<div id="main" class="clearfix">

			<div id="container">
				<div id="content" role="main">
					<div class="post type-post status-publish format-standard">
						<h2 class="entry-title">IATI Explorer Toolkit</h2>
						
						<p>
							The International Aid Transparency Initiative has created an XML standard and processes for donors to publish information on aid projects, budgets and spending. A log of all published IATI data is kept on the <a href="http://www.iatiregistry.org">IATI Registry</a> where you can download XML files directly from donors and other information sources. 
						</p>
						
						<p>
							During 2011 this site hosted a number of experimental tools for accessing IATI data. A number of these are now deployed directly on the <a 
href="http://www.iatiregistry.org">IATI Registry</a> or on third-party platforms like the <a href="http://www.iatiexplorer.org">IATI Explorer</a>.
						</p>
						<p>
							You can find a list of tools for working with IATI Data on the <a href="http://wiki.iatistandard.org">IATI Technical Community Wiki</a>. Further tools to provide end-user 
access to IATI data are currently under development.
						</p>						
					</div><!--.post-->
					
				</div><!-- #content -->
			</div><!-- #container -->



			<div id="sidebar" class="widget-area" role="complementary">
				<ul class="xoxo">
					<li id="text-3" class="widget-container widget_text"><h3 class="widget-title">Beta</h3>
							<div class="widget-content">
								<p>This is an early prototype and is a work-in-progress. </p>
								<p>Please drop comments/questions/bug reports/feedback to <a href="mailto:aidinfo@practicalparticipation.co.uk">aidinfo@practicalparticipation.co.uk</a> or discuss on the <a href="http://aidinfolabs.org/archives/422">AidInfoLabs site</a>.
								</p>
							</div>
						</li>	

						<li id="text-3" class="widget-container widget_text"><h3 class="widget-title">About the Data</h3>					
						<div class="widget-content">
							<p>
							Data is published part of the International Aid Transparency Initiative by individual donors, often in a different file for each country they work in, and is listed in the <a href="http://iatiregistry.org/">IATI Registry</a>. This tool uses data fetched from all those files, and aggregated together in an <a href="http://www.exist-db.org">XML database</a> to allow you to query the data and convert it into the format you want.
							</p>
							
							
						</div>
					</li>
					
					<li id="text-3" class="widget-container widget_text"><h3 class="widget-title">Useful links</h3>					
					<div class="widget-content">
						<p><a href="http://www.iatiregistry.org" target="_blank">IATI Registry</a> (IATI Data)</p>
						<p><a href="http://www.aidtransparency.net" target="_blank">Aid Tranparency </a> (IATI Project Site)</p>
						<p><a href="http://www.aidinfolabs.org" target="_blank">Aid Info Labs</a> (Ideas and tools)</p>
						<p><a href="http://www.github.com/aidinfolabs" target="_blank">Aid Info Labs on GitHub</a> (Shared source code)</p>
						<p><a href="http://www.aidinfo.org" target="_blank">AidInfo</a> (Aid information news and update)</p>
						</p>
						
						
					</div>
				</li>
				
				</ul>

			</div><!-- #sidebar .widget-area -->
		</div><!-- #main -->

				<div id="footer" role="contentinfo"> 
					<div id="colophon"> 
 						<div id="site-generator" class="clearfix"> 
						</div><!-- #site-generator --> 
					</div><!-- #colophon --> 
				</div><!-- #footer --> 

			</div><!-- #wrapper -->
	
	




</body>
</html>
