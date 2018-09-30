<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');
$layout = $app->input->getCmd('layout', '');
$task = $app->input->getCmd('task', '');
$itemid = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if ($task == "edit" || $layout == "form") {
    $fullWidth = 1;
} else {
    $fullWidth = 0;
}

// Add Stylesheets
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/min/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/min/font-awesome.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/easy-autocomplete.css');

// Add scripts
JHtml::_('jquery.framework');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/min/jquery.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/min/bootstrap.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/min/jquery.easy-autocomplete.min.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/min//jquery.easy-autocomplete.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/template.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/autocomplete.js');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/validate.js');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <jdoc:include type="head" />
        <?php if($this->params->get('favicon')) { ?>
            <link rel="shortcut icon" href="<?php echo JUri::root(true) . htmlspecialchars($this->params->get('favicon'), ENT_COMPAT, 'UTF-8'); ?>" />
        <?php } ?>
        <!--[if lt IE 9]>
                <script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <header>
            <h1 class="heading text-center"><a href="<?=JUri::base();?>"><?php echo $sitename; ?></a></h1>
        </header>
        <div class="body">
            <div class="content">
                <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                    <h4 class="sub-heading">Welcome</h4>
                    <jdoc:include type="modules" name="banner" style="xhtml" />
                    <?php if ($this->countModules('breadcrumbs')) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <jdoc:include type="modules" name="breadcrumbs" style="xhtml" />
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <main id="content" role="main" class="col-md-12">
                            <jdoc:include type="modules" name="search" style="xhtml" />
                            <jdoc:include type="message" />
                            <jdoc:include type="component" />
                        </main>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-faded text-muted" role="contentinfo">
            <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                <div class="row">
                    <div class="col-sm-12 text-center">
		        <p>
                            &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <jdoc:include type="modules" name="debug" style="none" />
    </body>
</html>
