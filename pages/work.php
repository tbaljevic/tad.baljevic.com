<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Timeline
{
	private $_years = array();
	
	public function __construct ()
	{
		$this->_years = array();
	}
	
	public function addYear ($year)
	{
		$newYear = new TimelineYear($year);
		$this->_years[] = $newYear;
		return $newYear;
	}
	
	public function render ()
	{
		$html = "<div class='timeline'>";
		
		$side = "right";
		foreach ($this->_years as $year) {
			$output = $year->render($side);
			$side = $output['side'];
			$html .= $output['html'];
		}
		
		$html .= "</div>";
		
		echo $html;
	}
}


class TimelineYear
{
	private $_year;
	private $_timelineEntries;
	
	public function __construct ($year)
	{
		$this->_year = $year;
		$this->_timelineEntries = array();
	}
	
	public function addEntry ($type, $icon, $company, $role, $heading, $dates, $description)
	{
		$this->_timelineEntries[] = new TimelineEntry($type, $icon, $company, $role, $heading, $dates, $description);
	}
	
	public function render ($side)
	{
		$html = "<p class='timeline-year'>{$this->_year}</p>";
		$html .= "<ul class='timeline-list'>";
		

		foreach ($this->_timelineEntries as $entry) {
			// Swap Sides
			if ($side == "left") {
				$side = "right";
			} else {
				$side = "left";
			}
			
			$html .= $entry->render($side);
		}
		
		$html .= "</ul>";
		
		$output = array(
				'html' => $html,
				'side' => $side
			);
		
		return $output;
	}
}


class TimelineEntry
{
	private $_type;
	private $_iconUrl;
	private $_company;
	private $_role;
	private $_heading;
	private $_dates;
	private $_description;

	public function __construct ($type, $icon, $company, $role, $heading, $dates, $description)
	{
		$this->_type = $type;
		$this->_iconUrl = $icon;
		$this->_company = $company;
		$this->_role = $role;
		$this->_heading = $heading;
		$this->_dates = $dates;
		$this->_description = $description;
	}
	
	public function render ($side)
	{
		//The side the entry will appear
		if ($side == "right") {
			$sideClass = "timeline-entry-right";
		} else {
			$sideClass = "timeline-entry-left";
		}
		
		// The colour of the panel
		$colourClass = "timeline-blue"; // Default
		if ($this->_type == "achievement") {
			$colourClass = "timeline-green";
		} elseif ($this->_type == "employment") {
			$colourClass = "timeline-blue";
		}
	
		$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
		return "
		<li class='timeline-entry {$colourClass} {$sideClass}'>
			<div class='timeline-entry-content {$colourClass}'>
				<div class='timeline-entry-company'>
					<img class='center timeline-entry-company-image' src='{$path}{$this->_iconUrl}'></img>
					<hr>
					<p class='center timeline-entry-company-name'>{$this->_company}</p>
				</div>
				<div class='timeline-entry-details {$colourClass}'>
					<p class='center timeline-entry-heading'>{$this->_heading}</p>
					<p class='center timeline-entry-role'>{$this->_role}</p>
					<p class='center timeline-dates'>{$this->_dates}</p>
					<p class='timeline-entry-description'>{$this->_description}</p>
				</div>
			</div>
		</li>";
	}
}


class SkillsManager
{
	private $_skillDomains;
	
	public function __construct ()
	{
		$this->_skillDomains = array();
	}
	
	public function addSkillDomain ($title)
	{
		$skillDomain = new SkillDomain($title);
		$this->_skillDomains[] = $skillDomain;
		return $skillDomain;
	}
	
	public function render ()
	{
		$html = "<div class='skills'>";
		
		foreach ($this->_skillDomains as $skillDomain) {
			$html .= $skillDomain->render();
		}
		
		$html .= "</div>";
		
		echo $html;
	}
}


class SkillDomain
{
	private $_title;
	private $_skills;
	
	public function __construct ($title)
	{
		$this->_title = $title;
		$this->_skills = array();
	}
	
	public function addSkill ($title, $proficiency)
	{
		$skill = new Skill($title, $proficiency);
		$this->_skills[] = $skill;
		return $skill;
	}
	

	public function render ()
	{
		$html = "<table class='skill-domain'><tr><th colspan='2'>{$this->_title}</th></tr>";
		
		foreach ($this->_skills as $skill) {
			$html .= $skill->render();
		}
		
		$html .= "</table>";
		
		return $html;
	}
}

class Skill
{
	private $_title;
	private $_proficiency;
	
	public function __construct ($title, $proficiency)
	{
		$this->_title = $title;
		$this->_proficiency = $proficiency;
	}
	
	public function render ()
	{
		$html = "<tr><td class='skill'>{$this->_title}</td><td><div class='proficiency-points'>";
		
		$pcount = 0;
		while ($pcount < $this->_proficiency) {
			$html .= "<div class='proficiency-point'></div>";
			$pcount += 1;
		}
		
		$html .= "</div></td></tr>";
		return $html;
	}
}


// Creating the Skill Domains and skills
$skillsManager = new SkillsManager();

$skillDevelopment = $skillsManager->addSkillDomain("Software Development");
$skillDevelopment->addSkill("HTML/CSS", 5);
$skillDevelopment->addSkill("Javascript", 5);
$skillDevelopment->addSkill("SQL", 4);
$skillDevelopment->addSkill("Python", 4);
$skillDevelopment->addSkill("PHP", 4);
$skillDevelopment->addSkill("ReactJS", 2);
$skillDevelopment->addSkill("JQuery", 2);

$skillTech = $skillsManager->addSkillDomain("Other Technical");
$skillTech->addSkill("Freemarker", 5);
$skillTech->addSkill("Git", 3);
$skillTech->addSkill("Linux", 3);

$skillTech = $skillsManager->addSkillDomain("Analytical");
$skillTech->addSkill("Requirements Analysis", 5);
$skillTech->addSkill("Solutions Design", 5);

$skillDesign = $skillsManager->addSkillDomain("3D Design");
$skillDesign->addSkill("3ds Max", 4);
$skillDesign->addSkill("Blender", 4);
$skillDesign->addSkill("ZBrush", 3);
$skillDesign->addSkill("Mudbox", 2);

$skillDesign = $skillsManager->addSkillDomain("2D Design");
$skillDesign->addSkill("GIMP", 5);
$skillDesign->addSkill("Premiere", 3);
$skillDesign->addSkill("Photoshop", 3);

$skillLanguage = $skillsManager->addSkillDomain("Languages");
$skillLanguage->addSkill("English", 5);
$skillLanguage->addSkill("Pig Latin", 3);
$skillLanguage->addSkill("French", 1);


// Creating the Timeline and its entries
$timeline = new Timeline();

$y18 = $timeline->addYear("2018");
$y18->addEntry(
	"employment",
	"resources/images/company_icons/google.png",
	"Google London",
	"Technical Solutions Consultant, GTech",
	"Joined Google",
	"November 2018",
	""
);
$y18->addEntry(
	"employment",
	"resources/images/company_icons/animal-logic.png",
	"Animal Logic Vancouver",
	"Technical Configuration Administrator",
	"Animal Logic",
	"May 2016 - August 2018 (2 years, 4 months)",
	"In this role I was responsible for the management, analysis and configuration of the internal production management system, as well as the development and maintenance of a suite of production reporting tools.
	<br><br>
	Some notable achievements include:
	<ul>
		<li>the successful creation and implementation of a suite of Production Batch Reporting tools;</li>
		<li>a clean-up and implementation of the Catering System for use in Vancouver;</li>
		<li>automation of production tracking and reporting across departments;</li>
		<li>automation of the department handover pipeline.</li>
	</ul>
	"
);

$y17 = $timeline->addYear("2017");
$y17->addEntry(
	"achievement",
	"resources/images/achievement_icons/gridtablejs.png",
	"GridTableJS",
	"Developer",
	"Released GridTableJS",
	"December",
	"GridTableJS is a JavaScript library designed to simplify the creation of tables with complex layouts. It was developed as a personal side-project and released under a GPL License. You can <a href='https://github.com/tbaljevic/GridTableJS'>check it out on my GitHub profile</a>."
);
$y17->addEntry(
	"achievement",
	"resources/images/achievement_icons/tlnm.jpg",
	"The LEGO Ninjago Movie",
	"",
	"Credited on 'The LEGO Ninjago Movie'",
	"September",
	""
);
$y17->addEntry(
	"achievement",
	"resources/images/achievement_icons/tlbm.jpg",
	"The LEGO Batman Movie",
	"",
	"Credited on 'The LEGO Batman Movie'",
	"February",
	""
);

$y16 = $timeline->addYear("2016");
$y16->addEntry(
	"achievement",
	"resources/images/achievement_icons/themaster.jpg",
	"The Master",
	"",
	"Credited on 'The Master'",
	"September",
	"A LEGO Ninjago Short."
);
$y16->addEntry(
	"employment",
	"resources/images/company_icons/animal-logic.png",
	"Animal Logic Vancouver",
	"Technical Configuration Administrator",
	"Transferred to Vancouver",
	"May",
	"Transferred to Animal Logic Vancouver from Sydney."
);

$y15 = $timeline->addYear("2015");
$y15->addEntry(
	"employment",
	"resources/images/company_icons/uts.png",
	"University of Technology, Sydney",
	"Academic Tutor",
	"Left UTS",
	"July 2013 - July 2015 (2 years)",
	"In preparation for moving to Vancouver, I left UTS."
);

$y14 = $timeline->addYear("2014");
$y14->addEntry(
	"employment",
	"resources/images/company_icons/animal-logic.png",
	"Animal Logic Sydney",
	"Technical Configuration Administrator",
	"Joined Animal Logic",
	"December",
	"Following the completion of Westpac's graduate program, I joined Animal Logic as a Technical Configuration Administrator."
);
$y14->addEntry(
	"employment",
	"resources/images/company_icons/westpac.png",
	"Westpac Banking Corporation",
	"IT Business Analyst (Westpac Graduate Program)",
	"Left Westpac",
	"February 2013 - December 2014 (1 year, 11 months)",
	""
);

$y13 = $timeline->addYear("2013");
$y13->addEntry(
	"employment",
	"resources/images/company_icons/uts.png",
	"University of Technology, Sydney",
	"Academic Tutor",
	"Joined UTS",
	"July",
	"As an Academic Tutor, I was responsible for coordinating, marking, teaching and developing coursework as well as mediating student issues.<br><br>I taught two subjects:<br/><ul><li>'Collaborative Business Processes' introduced students to business development and administration. The semester-long goal was to create a product and develop it from a concept to a fully-realised business.</li><li>'Business Process and IT Strategy' had students analyse business research focussed on the relationships between business, IT and strategy.</li></ul>"
);
$y13->addEntry(
	"employment",
	"resources/images/company_icons/westpac.png",
	"Westpac Banking Corporation",
	"IT Business Analyst (Westpac Graduate Program)",
	"Joined Westpac as a Graduate",
	"February",
	"Following my graduation from university, I joined Westpac's IT Graduate Program. Within four rotations, I was able to assist with the successful completion of:
	<ul>
		<li>a highly-publicised proof-of-concept Windows Surface App for financial planners;</li>
		<li>the implementation of the BT Advisor Services (BTAS) platform;</li>
		<li>process improvements in reporting and tracking the highly volatile Change/Problem/Incident Management teams; and</li>
		<li>the implementation of the Trade Lifecycle Manager (TLM) tool.</li>
	</ul>"
);


?>

<h1>Skills &amp; Experience.</h1>

<p class='center'>Below is a brief outline of my professional experience. Please <a href='https://www.linkedin.com/in/tadbaljevic'>refer to my LinkedIn profile</a> for further details regarding my education, achievements and skills. For examples of my work, please <a href='https://github.com/tbaljevic'>refer to my GitHub profile</a>.</p>

<div class="break"></div>

<h2>Skills</h2>
<?= $skillsManager->render(); ?>

<div class="break"></div>

<h2>Timeline</h2>
<?= $timeline->render(); ?>
