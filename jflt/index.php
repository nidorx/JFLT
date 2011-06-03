<?

// no direct access
defined('_JEXEC') or die('Restricted index access');
define('JFLT_EXEC', true);
if (!defined('DS'))
{
    define('DS', DIRECTORY_SEPARATOR);
}

// load and inititialize JFT class
require_once(realpath(dirname(__FILE__)) . DS . 'lib' . DS . 'Jflt' . DS . 'jflt.php');
global $jflt;
$jflt = jflt::get();

$headerstuff = $this->getHeadData(); // pega os dados do cabeçalho
unset($headerstuff['scripts'][$this->baseurl . '/media/system/js/mootools.js']); // remove mootools 1.11
unset($headerstuff['scripts'][$this->baseurl . '/media/system/js/caption.js']); // remove caption
// Insere o novo mootools
$headerstuff['scripts'] = array_merge(
        array('https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js' => 'text/javascript'), $headerstuff['scripts']
);
$this->setHeadData($headerstuff); // carrega as modificações efetuadas
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br" >

    <head>
        <jdoc:include type="head" />
        <?
        $this->addScript($jflt->templateUrl . '/js/mootools-core.js');
        $this->addScript($jflt->templateUrl . '/js/mootools-more.js');

        $jflt->addStyleSheet($jflt->templateUrl . '/css/960_12grid.css');
        $jflt->addStyleSheet($jflt->templateUrl . '/css/estilo.css');
        $jflt->addStyleSheet($jflt->templateUrl . '/css/text.css');

        $jflt->displayHead();
        ?>
    </head>

    <body <?= ($jflt->isHome()) ? 'class="home"' : ''; ?>>

        <noscript>
            <link type="text/css" href="<?= $jflt->templateUrl . '/css/site_noscript.css'; ?>" rel="stylesheet"/>
        </noscript>
        <div id="top-surround">
            <? /** Begin Top * */ if ($jflt->countModules('top')) : ?>
                <div id="top">
                    <div class="container">
                        <?= $jflt->displayModules('top'); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            <? /** End Top * */ endif; ?>


            <? /** Begin Header * */ if ($jflt->countModules('header')) : ?>
                <div id="header">
                    <div class="container">
                        <?= $jflt->displayModules('header'); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            <? /** End Header * */ endif; ?>


            <? /** Begin Menu * */ if ($jflt->countModules('menu')) : ?>
                <div id="menu">
                    <div class="container">
                        <div id="logo"></div>
                        <?= $jflt->displayModules('menu'); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            <? /** End Menu * */ endif; ?>

            <? /** Begin Rotator * */ if ($jflt->countModules('rotator')) : ?>
                <div id="rotator">
                    <div class="container">
                        <?= $jflt->displayModules('rotator'); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            <? /** End Rotator * */ endif; ?>


        </div>

        <div id="body-surround">
            <div class="container">
                <div id="body-bg" class="header-full footer-full">
                    <div id="body-bg2">
                        <div id="body-bg3">
                            <div id="body-bg4">
                                <? /** Begin Showcase * */ if ($jflt->countModules('showcase')) : ?>
                                    <div id="showcase">
                                        <div class="container">
                                            <?= $jflt->displayModules('showcase'); ?>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <? /** End Showcase * */ endif; ?>
                                <? /** Begin Feature * */ if ($jflt->countModules('feature')) : ?>
                                    <div id="feature">
                                        <div class="container">
                                            <?= $jflt->displayModules('feature'); ?>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <? /** End Feature * */ endif; ?>
                                <? /** Begin Utility * */ if ($jflt->countModules('utility')) : ?>
                                    <div id="utility">
                                        <div class="container">
                                            <?= $jflt->displayModules('utility'); ?>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <? /** End Utility * */ endif; ?>

                                <? /** Begin Main Top * */ if ($jflt->countModules('maintop')) : ?>
                                    <div id="maintop">
                                        <div class="container">
                                            <?= $jflt->displayModules('maintop'); ?>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <? /** End Main Top * */ endif; ?>
                                <? /** Begin Main Body * */ ?>
                                <div id="main">
                                    <div class="container">
                                        <?= $jflt->displayMainbody('main'); ?>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <? /** End Main Body * */ ?>
                                <? /** Begin Main Bottom * */ if ($jflt->countModules('mainbottom')) : ?>
                                    <div id="mainbottom">
                                        <div class="container">
                                            <?= $jflt->displayModules('mainbottom'); ?>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <? /** End Main Bottom * */ endif; ?>
                                <? /** Begin Bottom * */ if ($jflt->countModules('bottom')) : ?>
                                    <div id="bottom">
                                        <div class="container">
                                            <?= $jflt->displayModules('bottom'); ?>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                <? /** End Bottom * */ endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="footer-surround">
            <div class="container">

                <? /** Begin Footer * */ if ($jflt->countModules('footer')) : ?>
                    <div id="footer">
                        <div class="container">
                            <?= $jflt->displayModules('footer'); ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                <? /** End Footer * */ endif; ?>
                <? /** Begin Copyright * */ if ($jflt->countModules('copyright')) : ?>
                    <div id="copyright">
                        <div class="container">
                            <?= $jflt->displayModules('copyright'); ?>
                            <div class="clear"></div>
                        </div>
                    </div>
                <? /** End Copyright * */ endif; ?>

            </div>
        </div>

        <? /** Begin Debug * */ if ($jflt->countModules('debug')) : ?>
            <div id="debug">
                <div class="container">
                    <?= $jflt->displayModules('debug'); ?>
                    <div class="clear"></div>
                </div>
            </div>
        <? /** End Debug * */ endif; ?>
        <? /** Begin Analytics * */ if ($jflt->countModules('analytics')) : ?>
            <?= $jflt->displayModules('analytics'); ?>
        <? /** End Analytics * */ endif; ?>

    </body>
</html>

