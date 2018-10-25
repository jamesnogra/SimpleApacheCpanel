<!DOCTYPE html>
<html>

<head>
	<title>Simple Apache CPanel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-win8.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="w3-container w3-win8-crimson w3-center">
	<h1>Websites of <?php echo $_SERVER['REMOTE_ADDR']; ?></h1>
</div>

<div style="position:absolute;top:47px;right:20%;">
	<button onClick="showAddDomainModal();" class="w3-button w3-large w3-circle w3-xlarge w3-ripple w3-win8-crimson w3-card-4" style="z-index:0">+</button>
</div>

<div class="w3-row">
	<div class="w3-col m1">&nbsp;</div>
	<div class="w3-col m10">
		<ul class="w3-ul w3-card-4" id="all-domains" style="font-size:large;"></ul>
	</div>
	<div class="w3-col m1">&nbsp;</div>
</div>

<div id="add-domain" class="w3-modal">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-win8-crimson"> 
			<span onclick="hideAddDomainModal();" class="w3-button w3-display-topright">&times;</span>
			<h2>Add Domain</h2>
		</header>
		<div class="w3-container">
			<p>
				<label>Server Name</label>
				<input class="w3-input" type="text" id="server_name" placeholder="www.mydomain.com or sub.mydomain.com">
			</p>
			<p>
				<label>Server Alias</label>
				<input class="w3-input" type="text" id="server_alias" placeholder="mydomain.com (optional)">
			</p>
			<p>
				<input class="w3-check" type="checkbox" checked="checked" id="wordpress" value="true">
				<label for="wordpress">Install Wordpress</label>
			</p>
		</div>
		<footer class="w3-container w3-win8-crimson">
			<p class="w3-center">
				<button class="w3-btn w3-white" onClick="hideAddDomainModal();">Cancel</button>
				<button class="w3-btn w3-white" onClick="addDomainToDB()">Add</button>
			</p>
		</footer>
	</div>
</div>

<script>
	$(document).ready(function() {
		getAllDomains();
	});

	function getAllDomains() {
		$.get("all-domains.php", function(all_domains) {
			for (var x=0; x<all_domains.length; x++) {
				$('#all-domains').html(all_domains);
			}
		});
	}

	function addDomainToDB() {
		if ($('#server_name').val().length==0) {
			alert('Server name (domain name) is required in creating a website.');
			return;
		}
		var data = {
			'server_name':  	$('#server_name').val(),
			'server_alias':  	$('#server_alias').val(),
			'wordpress':  		($('#wordpress').is(":checked")?'true':'false'),
			'done':  			'false',
		};
		hideAddDomainModal();
		$.post("add-domain.php", data, function(all_domains) {
			getAllDomains();
		});
	}

	function deleteDomain(domain_id) {
		$('#domain-'+domain_id).remove();
	}

	function hideAddDomainModal() {
		document.getElementById('add-domain').style.display='none';
	}

	function showAddDomainModal() {
		document.getElementById('add-domain').style.display='block';
	}
</script>

</body>
</html>