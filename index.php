<?php
// Hide errors
error_reporting(0);
ini_set('display_errors', 0);

// Override default PHP configurations
ini_set('max_execution_time',360);
ini_set('max_memory','512M');

  $transformations = array(
  	"simple" => array("xslt" => "csv/simple-activity-listing.xsl",
					"title" => "Simple activity summary",
					"description" => "Top-level information with a row for each aid activity. Total figures for each type of transaction. Sector codes are included as a ';' separated list. Useful for basic research.",
					"notes" => "If an activity contains transactions in multiple currencies this will not be taken into account when transaction totals are calculated. To ensure accuracy in financial analysis use the transaction data."),
	"full" => array("xslt" => "csv/iati-activities-xml-to-csv.xsl",
					"title" => "Full activity data",
					"description" => "Full flattened version of each IATI Activity record - one row per activity. Where multiple values exist for a column (e.g. multiple sectors, or many transactions) these are separated by ';'.",
					"notes" => "This data can be reshaped using a tool like Google Refine for analysis along any of it's dimensions. If an activity contains transactions in multiple currencies this will not be taken into account when transaction totals are calculated. To ensure accuracy in financial analysis use the transaction data. "),
	"transac" => array("xslt" => "csv/iati-transactions-xml-to-csv.xsl",
						"title" => "All transactions",
						"description" => "Detailed list of all transactions, with currencies, amounts and classifications with a row for each transaction.",
						"notes" => "")
  );

 if($_GET['download']) {
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=iati_download_".date("Ymd")."_".$_GET['format']."_".$_GET['id'].".csv");
	header("Content-type: text/csv");
	$xml = urldecode($_GET['xml']);
	$xmlDoc = new DOMDocument;
	$data = file_get_contents(str_replace(' ','%20',$xml));
	$xmlDoc->loadXML($data);

	if($xmlDoc->getElementsByTagName('iati-activity')->item(0)) {
	   $xslDoc = new DOMDocument();
   	   $xslDoc->load($transformations[$_GET['format']]['xslt']);

	   $proc = new XSLTProcessor();
	   $proc->importStylesheet($xslDoc);

	   $outdir = "";

	   $proc->transformToURI($xmlDoc, 'php://output');
	   ob_flush();
	   exit();

   } else {
       $complete = 1;
	   $error = "We could not find IATI data for the country or option you selected";
   }
}

?>
<html>
	<head>
		<title>Raw data preview and tools</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<style><!--
		* {
	        margin: 0;
	        padding: 0;
	    }

		p {
			margin-bottom:1em;

		}
	    body {
	        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	        margin: 10px;
	        color: #292416;
	        background-color: #f8f8f8;
	    }

	    h1 {
	        font-size: 24px;
	        border-bottom: 1px solid #b8ad98;
	        padding: 0 5px 3px 5px;
	        margin: 0 10px 5px 10px;
	    }


	    div {
	        background-color: #fff;
	        padding: 10px 15px;
	        margin-bottom: 15px;
	        -webkit-border-radius: 10px;
	    	-moz-border-radius: 10px;
	    	border-radius: 10px;
	    }

	ul {
		padding-left:30px;
	}

	.tool {
		display:block;
		clear:all;
		margin:10px;
	}
	.note {
		display:block;
		clear:left;
		font-size:smaller;
		margin-top:10px;
	}
	.tool_link {
		display:block;
		float:right;
	}

	label {
		font-weight:bold;
	}

	.loading {
		background-image:url('loading.gif');
		background-repeat:no-repeat;
		background-position: 370px 0px;
	}

	#package_list {
		width:400px;
	}

	fieldset {
		margin-bottom:10px;
		padding:5px;
	}

	.footnote {
		font-size:small;
	}
--></style>

	<script><!--
		$(document).ready(function() {
			function ckan_populate(search,offset) {
				limit = 20;
				if(search) { search_string = "q="+search; } else { search_string = "res_format=IATI-XML"; }
				if(offset == null) { offset = 0; }
				$.ajax({
				  url: "http://iatiregistry.org/api/1/search/package?"+search_string+"&all_fields=1&limit="+limit+"&offset="+offset,
				  context: document.body,
				  success: function(data){
					if(search == $("#ckan_search").val()) { //In case the search has changed in the meantime
						count = data['count'];
						$("option.message").remove();
						if(offset == 0) { $("#package_list").empty();
										  $("#package_list").addClass("loading"); }
						if(count == 0) { $("#package_list").append("<option value='' class='message'>No packages found...</option>"); }
						$.each(data['results'], function(index, data) {
							$("#package_list").append("<option value='"+data['name']+"'>"+data['title']+"</option>");
						});
						if((offset+limit)<count) {
							if(offset == 0) {
								$("#package_list").append("<option value='loadmore-"+limit+"' class='message'>Load "+(count-limit)+" more results...</option>");
								$("#package_list").removeClass("loading");
							} else {
								ckan_populate(search,offset+limit);
							}
						} else {
							$("#package_list").removeClass("loading");
						}
					}
				  }
				});
			}

			$("#package_list").change(function(data) {
				if($(this).val().indexOf("loadmore") !==-1)
				 {
					$("#package_list").addClass("loading");
					ckan_populate($("#ckan_search").val(),parseInt($(this).val().replace("loadmore-","")));
				} else {
					$(".url_field").val('');
					$("#xml").val('Updating...');
						$.ajax({
						  url: "http://iatiregistry.org/api/1/rest/package/"+$(this).val(),
						  context: document.body,
						  success: function(data){
							$(".url_field").val(data['download_url']);
							$(".id_field").val(data['name']);
						  }
					    });
				}
			});

			$("legend, #iati_reg_expand ").click(function() {
				$(this).parents("fieldset").children("div").toggle('slow');
			});

			$("#download, #reset_link").click(function() {
				$(".section").toggle('fast');
			});

			$("#xml").change(function(){
				$(".id_field").val("Custom");
			});

			$("#search_index").click(function(){
				$("#package_list").empty();
				$("#package_list").append("<option value=''>Loading...</option>");
				ckan_populate($("#ckan_search").val())
			});

			ckan_populate('');
		});

	--></script>
	</head>
	<body>

	<form method="get" action=".">
		<h1 class="title">CSV Conversion Tool</h1>
			<div class="section">
				<h3>(1) Select the data to convert</h3>

				<fieldset>
				    <legend>IATI Registry Search:</legend>
					<div class="ckan" <?php if($_GET['xml']) { echo "style='display:none;'"; }?>>
						<label for="ckan_search">Search: <input type="text" name="search" class="ckan_search" id="ckan_search"/></label> <input type="button" value="Search" id="search_index"><br/><br/>
						<select name="package" id="package_list" size="10">
							<option value="">Loading...</option>
						</select><br/>
						<span class="instruction">Select an item from the list above, or narrow the selection by typing in a search query (e.g. a country or donor name).</span>
					</div>
					<div class="search" <?php if(!$_GET['xml']) { echo "style='display:none;'"; }?>>
						<span class="instruction">Enter/confirm the URL below, or <A href="#" id="iati_reg_expand">select a file from the IATI registry</a>.</span>
					</div>
				</fieldset>

				<fieldset>
				    <legend>Raw data address:</legend>
					<label for="xml">URL: <input class="url_field" type="text" size="60" value="<?php echo $_GET['xml']; ?>" id="xml" name="xml" /></label>
				</fieldset>
			</div>

			<div class="section">
				<h3>(2) Select File Format</h3>
				Select the CSV (spreadsheet) serialisation of IATI data you would prefer.
					<input type="hidden" name="download" value="true" />
					<input type="hidden" name="id" value="true" class="id_field"/>
				<?php
					if($_GET['format']) { $checked = $_GET['format']; } else {$checked = array_shift(array_keys($transformations)); }
					foreach($transformations as $key => $transdata) {
					echo "<div class='format'>";
					echo "<label for='{$key}'><input type='radio' name='format' value='{$key}' id='{$key}'".($key == $checked ? "checked='checked'" : "") ."/> {$transdata['title']} (CSV)</label><br/>";
					echo "<span class='description'>".$transdata['description']."</span>";
					echo "</div>";
				}?>
				<input type="Submit" value="Download" id="download"/ >

			</div>
	</form>
			<div class="section" style="display:none;">
				<h3><a name="use">(3) Use your data</a></h3>
				<br/>
				<p>
				Your file should start downloading shortly. For very large files this process could take a few minutes*.
				</p>
				<p>
				If you would like to download another file once this is complete, <a href="#" id="reset_link">click here</a>.
				</p>
				<h4>Once you have IATI data in CSV format</h4>
				<p>
				You can:
				<ul>
					<li>Open it in Excel or other spreadsheet software;
					<li>Import the data into your preferred statistical software package;
					<li><a href="http://www.aidinfolabs.org/archives/444" target="_blank">Reshape the data using Google Refine</a>;
					<li>And lots more
				</ul>
				</p>
				<p>
				You can <a href="http://support.iatistandard.org/entries/20680393-csv-spreadsheet-version-of-iati" target="_blank">discuss use of IATI in CSV format on the IATI Support Knowledge Base website</a>.
				</p>
				<h4>Troubleshooting</h4>
				<p>
				<i>Having difficulty opening your downloaded file?</i> Check that it has a .csv file extension and that Excel, or your spreadsheet software, is configured as the default application for this kind of file. If clicking the file will not open it, try accessing it from the File->Open menu of your spreadsheet software.
				</p>
				<p>
				<i>Need a different format?</i> Turning the rich raw IATI data files into a flat spreadsheet form means we have make a decision about what to include in the spreadsheet version. Sometimes the default choices available here might not suit your proposed use of IATI data. Get in touch via <a href="http://support.iatistandard.org" target="_blank">IATI Support</a> if you are in need of a different data format .
				</p>
				<span class="footnote">*There are a few IATI XML files that are too large to convert with this tool. For help with these please contact IATI support explaining how you plan to use them for advice on the best approaches to convert this data.</span>
			</div>
	<hr/>
	<small>Developed by <a href="http://www.practicalparticipation.co.uk" target="_blank">Practical Participation</a> for <a href="http://www.aidinfolabs.org" target="_blank">aidinfo labs</a> using <a href="https://github.com/aidinfolabs/IATI-XSLT/" target="_blank">XSLT</a> based on work by Rob McKinnon.</small> It works with valid activity data files prepared using the <a href="http://www.iatistandard.org" target="_blank">International Aid Transparency Initiative standard</a>.
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45255890-1', 'aidinfolabs.org');
  ga('send', 'pageview');

</script>
	</body>
</html>
