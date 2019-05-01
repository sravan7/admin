<?php
    session_start();
?>
<header class="navbar navbar-inverse" aria-label="primary" >
    <div class="navbar-header">
      <a href="" class="navbar-brand"><img src="images/log.png" alt="placeholder logo" id="logo"></a>
      <h4 style="display: inline-block">IIITDM App Catalogue</h4>
    </div>
    <nav>
      <ul class="nav navbar-nav navbar-right" id="navUL">
        <li class="pt"><a href="">Rejected</a></li>
        <li class="pt"><a href="">Income</a></li>
        <li class="pt"><a href="logout.php">Logout</a></li>
        <li>
        <img src="<?=$_SESSION['userData']['picture'];?>" alt="profile" id="profile-img">
         <h6 style="display: block;">
        <?= $_SESSION['userData']["first_name"];?>
        </h6></li>
      </ul>
    </nav>
    <button type="button" onclick='showmenu()' id="menuIcon" class="btn btn-sm" aria-label="menu" >&#x2630;</button>
  </header>