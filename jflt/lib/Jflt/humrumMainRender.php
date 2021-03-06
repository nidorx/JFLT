<?php

/**
 * @package humrum
 * @subpackage  core.renderes
 * @version 0.2.0 Dezembro 2010
 * @author Alex Rodin - contato@alexrodin.com (email,msn,gtalk)
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * humrum! template system usa o Framework Joomla (http://www.joomla.org), um cms GNU/GPLv2
 *
 */
class HumrumMainRender {

    // wrapper for modules display
    function display($positionMain, $layout = 'standard', $chrome = 'standard', $pattern = null) {
        global $jft;

        $output = '';
        $main_positions = $this->positions["main"];
        $content_position = $this->positions["content"][0];
//        print_r($this->positions);
//        print_r($main_positions);
//        print_r($content_position);


        $output = '';
        $output .='<jdoc:include type="modules" name="breadcrumb" style="' . $chrome . '" />' . "\n";
        /* desenha os sidebars e o conteudo */
        $letters = 'a';
        foreach ($main_positions as $positionIndex => $gridSize) {
            $extraClass = '';
            $extraClass = 'grid_' . $gridSize . ' ' . $extraClass;
            if ($positionIndex == $content_position - 1) {//o content
                $output .= HumrumMainRender::renderContent(array('gridSize' => $gridSize, 'extraClass' => $extraClass));
            } else {
                $sidebarName = 'sidebar-' . $letters;
                $output .= HumrumMainRender::renderModule(array('sidebarName' => $sidebarName, 'gridSize' => $gridSize, 'extraClass' => $extraClass));
                $letters++;
            }
        }
        return $output;
    }

    /**
     * @param string $layout the layout name to render
     * @param array $params all parameters needed for rendering the layout as an associative array with 'parameter name' => parameter_value
     * @return void
     */
    /* cada renderer � respons�vel pela renderiza��o do sey layout */
    function renderModule($params = array(), $chrome = 'standard') {
        $output = '';
        $output .= '<div class="' . $params["extraClass"] . '">
                        <div id="' . $params["sidebarName"] . '">
                          <jdoc:include type="modules" name="' . $params["sidebarName"] . '" style="' . $chrome . '" />' . "\n" . '
                        </div>
                    </div>';
        return $output;
    }

    function renderContent($params = array()) {
        global $jft;
        $output = '';
        $output = '<div class=" ' . $params["extraClass"] . '">

                    <div id="content-top">
                        <div class="container">
                       ';
        $output .= $jft->displayModules('content-top');
        $output .= '
                             <div class="clear"></div>
                         </div>
                    </div>

                    <div class="block">                      
                        <div id="mainbody">
                         

                            <jdoc:include type="component" />


                          
                        </div>
                        <div class="clear"></div>
                     </div>



                     <div id="content-bottom">
                        <div class="container">';
        $output .= $jft->displayModules('content-bottom');
        $output .= '   <div class="clear"></div>
                         </div>
                    </div>
                  </div>';
        return $output;
    }

}
