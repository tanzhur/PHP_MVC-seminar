<html>
    <head>
        <META charset="Utf8"/>
        <script type="text/javascript" src="<?= base_url() ?>js/jquery-2.0.2.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>js/main.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>css/style.css" type="text/css" />	
    </head>
    <body>
		<div id="master">
			<header>
				<h1>*start</h1>
				<?php echo $header; ?>
			</header>
			<nav>			
				<?php echo $navigation; ?>		
				<div class="cleaner"></div>		
			</nav>			
			<!--content area-->
			<section id="contentarea">
				<!--messages-->
				<section>
					<div id="messages">
						<?php echo $messages; ?>
					</div>
				</section>
				<!--content-->
				<section>
					<?php echo $content; ?>
				</section>
			</section>
			<!--aside-->
			<aside>
				<!--tools section-->
				<section>
					<?php echo $aside; ?>
				</section>
			</aside>
			<div class="cleaner"></div>	
			<!--footer-->
			<footer>
				<?php echo $footer; ?>
			</footer>
		</div>
    </body>
</html>