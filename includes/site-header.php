<?php
$activePage = $activePage ?? '';
$navItems = [
 'home'=>['Home','index.html'],
 'about'=>['About','about.php'],
 'why'=>['Why','why.php'],
 'destinations'=>['Popular Destinations','destinations.php'],
 'gallery'=>['Gallery','gallery.php'],
 'booking'=>['Book Online','book-online.php'],
 'blog'=>['Blog','blog.php'],
 'contact'=>['Contact','contact.php']
];
?>
<div class="topbar"><div class="topbar-inner">
 <div class="top-contact"><a href="tel:+254721661734">☎ &nbsp;+254 721 661 734</a><a href="mailto:reservations@wintripsafaris.com">✉ &nbsp;reservations@wintripsafaris.com</a></div>
 <div class="socials" aria-label="Social links">
 <a href="https://www.facebook.com/wintripsafaris" target="_blank" rel="noopener" aria-label="Facebook">f</a>
 <a href="https://www.instagram.com/wintripsafaris" target="_blank" rel="noopener" aria-label="Instagram">◎</a>
 <a href="https://www.threads.com/@wintrip_safaris" target="_blank" rel="noopener" aria-label="Threads">@</a>
 </div><div class="top-account"><a href="contact.php">ENQUIRE</a><span>|</span><a href="book-online.php">PLAN A TRIP</a></div>
</div></div>
<header class="header"><div class="header-inner">
 <a class="logo" href="index.html" aria-label="Wintrip Safaris home"><img src="https://www.wintripsafaris.com/assets/images/logo.gif" alt="Wintrip Safaris"></a>
 <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
 <nav class="nav" aria-label="Main navigation">
 <?php foreach($navItems as $key=>$item): ?><a href="<?=htmlspecialchars($item[1],ENT_QUOTES)?>" class="<?=$activePage===$key?'active':''?>" <?=$activePage===$key?'aria-current="page"':''?>><?=htmlspecialchars($item[0])?></a><?php endforeach; ?>
 </nav>
 <button class="header-search" type="button" aria-label="Open website search" aria-expanded="false" aria-controls="site-search-panel"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.6"></circle><path d="m16 16 5 5"></path></svg></button>
</div></header>
<div class="site-search-panel" id="site-search-panel" hidden><form class="site-search-form" id="site-search-form" role="search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.6"></circle><path d="m16 16 5 5"></path></svg><input id="site-search-input" type="search" placeholder="Search destinations, tours and more..." autocomplete="off" aria-label="Search this website"><button type="button" class="site-search-close" aria-label="Close search">×</button></form><div class="site-search-results" id="site-search-results" aria-live="polite"><p>Try searching for a destination, safari or travel service.</p></div></div>