<?php
// Komponen Navbar Statis
$pageTitle = $pageTitle ?? 'GemaEnterprise';
?>
<nav class="navbar navbar-dark bg-primary" style="z-index: 1050; position: relative;">
    <div class="container-fluid">
        <span class="navbar-toggler-icon" id="sidebarToggle" onclick="toggleSidebar()" style="cursor: pointer; transition: all 0.3s ease; font-size: 1rem;"></span>
        <a class="navbar-brand ms-3" href="#"><?php echo $pageTitle; ?></a>
    </div>
</nav>