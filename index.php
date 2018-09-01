<?php


// GET the page name
$PAGE = $_GET['p'];
if ($PAGE == "") {
	$PAGE = "home";
}
$pagelink = "./pages/{$PAGE}.php";


// Classes to manage the nav menu.
class NavMenu
{
	private $_links;
	
	public function __construct ()
	{
		$this->_links = array();
	}
	
	public function addLink ($name, $title)
	{
		$link = new NavMenuLink($name, $title);
		$this->_links[] = $link;
	}
	
	public function render ($currentPage)
	{
		$html = "
		<div id='nav-menu' class='nav-menu'>
			<div class='nav-menu-outer'>
				<div class='nav-menu-inner'>
		";
		
		foreach ($this->_links as $link) {
			$html .= $link->render($currentPage);
		}
		
		$html .= "
				</div>
			</div>
		</div>
		";
		
		echo $html;
	}
}

class NavMenuLink
{
	private $_name;
	private $_title;
	
	public function __construct ($name, $title)
	{
		$this->_name = $name;
		$this->_title = $title;
	}
	
	public function render ($currentPage)
	{
		// Determine if rendering the NavMenuLink for the current page.
		// If so, we want to highlight it for visual clarity.
		
		$highlightClass = "";
		if ($this->_name == $currentPage) {
			$highlightClass = "nav-menu-item-current";
		}
		
		$html = "
		<div id='{$this->_name}' class='nav-menu-item {$highlightClass}'>
			<a href='./?p={$this->_name}' class='nav-menu-link'>
				<p class='nav-menu-text'>{$this->_title}</p>
			</a>
		</div>
		";
		
		return $html;
	}
}


// Create the Nav Menu Links
$navMenu = new NavMenu();
$navMenu->addLink("home", "Home");
$navMenu->addLink("work", "Work");
$navMenu->addLink("links", "Links");
$navMenu->addLink("contact", "Contact");

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<html>

<head>
	<meta charset="UTF-8">
	<title>Tad Baljevic - <?php echo ucfirst($PAGE); ?></title>

	<link rel="stylesheet" type="text/css" href="css/fonts.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/nav-menu.css">
</head>


<body>
	<div id="page" class="page">
		<div id="header" class="header">
			<h1 class='heading'>Tad Baljevic</h1>
		</div>
		<?= $navMenu->render($PAGE); ?>
<!--		<div id="nav-menu" class="nav-menu">
			<div class="nav-menu-outer">
				<div class="nav-menu-inner">
					<div id="home" class="nav-menu-item">
						<a href="./?p=home" class="nav-menu-link">
							<p class="nav-menu-text">Home</p>
						</a>
					</div>
					<div id="work" class="nav-menu-item">
						<a href="./?p=work" class="nav-menu-link">
							<p class="nav-menu-text">Work</p>
						</a>
					</div>
					<div id="links" class="nav-menu-item">
						<a href="./?p=links" class="nav-menu-link">
							<p class="nav-menu-text">Links</p>
						</a>
					</div>
					<div id="contact" class="nav-menu-item">
						<a href="./?p=contact" class="nav-menu-link">
							<p class="nav-menu-text">Contact</p>
						</a>
					</div>
				</div>
			</div>
		</div>-->
		<div id="content-wrapper" class="content-wrapper">
			<div id="content" class="content">
				<?php include_once($pagelink); ?>
			</div>
		</div>
	</div>
</body>

</html>
