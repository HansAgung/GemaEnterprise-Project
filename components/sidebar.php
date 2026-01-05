<?php
?>
<nav class="sidebar p-3" id="sidebar" style="width: 250px; position: fixed; left: -250px; transition: left 0.3s; z-index: 1000;">
    <h5>GemaEnterprise</h5>
    <ul class="list-unstyled" style="margin-top: 60px;">
        <li><a href="/GemaEnterprise/index.php">Dashboard</a></li>
        <li><a href="/GemaEnterprise/index.php?page=inventory">Inventory</a></li>
        <li><a href="/GemaEnterprise/index.php?page=kasir">Kasir</a></li>
        <li><button class="btn btn-outline-light mt-3" onclick="logout()">Logout</button></li>
    </ul>
</nav>

<!-- Overlay -->
<div id="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; display: none;" onclick="toggleSidebar()"></div>