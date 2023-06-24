<?php

// Fetch Server from mcsrvstat.us
function getServerStatus($address) {
    $url = "https://api.mcsrvstat.us/2/" . $address;
    $response = file_get_contents($url);
    $data = json_decode($response);

    return $data;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $address = $_POST['address'];
    $status = getServerStatus($address);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Minecraft Server Status</title>
    <meta name="description" content="The opensource website to fetch server data.">
    <meta name="author" content="Bijju089">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <header class="d-flex my-4">
	<img class="d-none d-sm-block" src="https://api.cxstudios.xyz/cdn/creeper.png" alt="Creeper" height="64" width="64">
	<div class="ms-sm-3">
        <h1>Minecraft Server Status</h1>
	<p class="h3 text-muted">Get status of Minecraft servers</p>
	</div>
</header>
<form method="POST" action="" class="mb-3">
	<div class="input-group input-group-lg">
                <label for="address" class="visually-hidden">Server IP:</label>
		<input type="text" name="address" id="address" placeholder="Enter Server Address to grab status" class="form-control" required>
		<button type="submit" name="submit" class="btn btn-primary">Get<span class="d-none d-sm-inline"> server status</span></button>
	</div>
	<div class="clearfix mt-1">
		<p class="float-end small text-muted">Servers with <code>enable-query=true</code> are displayed.</p>
	</div>
</form>

    <div id="server-status">
        <?php
        // Check if the server status is available
        if (isset($status) && $status->online) {
            $motd = implode("<br>", $status->motd->clean);
            $playerCount = $status->players->online;
            $maxPlayers = $status->players->max;
            $ip = $status->ip;
            $port = $status->port;
            $version = $status->version;
            echo "<div class='card'>";
            echo "<h2>Server Status:</h2>";
            echo "<p>Server IP: $address</p>";
            echo "<span class='minecraft'>$motd</span>";
            echo "<p>Server IP (Numerical): $ip</p>";
            echo "<p>Server Port: $port</p>";
            echo "<p>Protocol Version: $version</p>";
            echo "<p>Players Online: $playerCount / $maxPlayers</p>";
            echo "</div>";
        } elseif (isset($status) && !$status->online) {
            echo "&nbsp;<div class='alert alert-warning' role='alert'> This server is offline</div>";
        } else {
        echo "<h3 class='mt-4'>A non-profit project by <a href='https://github.com/bijju089'>Bijju089</a></h3>";
        echo "<small>Here are some cool people:</small>";
        echo "<div class='row'>
	<div class='col-md-6 mb-3 mb-md-0'>
		<div class='list-group'>
			<a class='list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3' href='https://api.mcsrvstat.us'>
				<span><b>MCsrvStatus</b></span>
				<span class='badge bg-light text-dark me-1'>API</span>
			</a>
			<a class='list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3' href='https://getbootstrap.com/'>
				<span><b>Bootstrap</b></span>
				<span class='badge bg-light text-dark me-1'>CSS</span>
			</a>
		</div>
	</div>
	<div class='col-md-6 mb-3 mb-md-0'>
		<div class='list-group'>
			<a class='list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3' href='https://cxstudios.xyz/'>
				<span><b>cxSTUDIOS</b></span>
				<span class='badge bg-light text-dark me-1'>ORG</span>
			</a>
			<a class='list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3' href='https://cxstudios.xyz/mcst/'>
				<span><b>MinecraftServers.tech</b></span>
				<span class='badge bg-light text-dark me-1'>PRT</span>
			</a>
		</div>
	</div>
</div>
";
}
        ?>
    </div>
</div>
<div>
</body>
</html>
