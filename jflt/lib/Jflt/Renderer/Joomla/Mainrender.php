<?php

// no direct access
defined('JFLT_EXEC') or die('Restricted access');

class Jflt_Renderer_Joomla_Mainrender
{

    // wrapper for modules display
    public function display($chrome = 'standard')
    {

        global $jflt;

        // print_r($jflt);

        $output = '';
        $main_positions = $jflt->positions["main"];
        $content_position = $jflt->positions["content"][0];

        $output = '';
        // $output .='<jdoc:include type="modules" name="breadcrumb" style="' . $chrome . '" />' . "\n";
        $output .= '<jdoc:include type="modules" name="breadcrumbs" style="' . $chrome . '" />' . "\n";
        /* desenha os sidebars e o conteudo */
        $letters = 'a';
        foreach ($main_positions as $positionIndex => $gridSize)
        {
            $extraClass = '';
            $extraClass = 'grid_' . $gridSize . ' ' . $extraClass;
            if ($positionIndex == $content_position - 1)
            {//o content
                $output .= $this->renderContent(array('gridSize' => $gridSize, 'extraClass' => $extraClass));
            } else
            {
                $sidebarName = 'sidebar-' . $letters;
                $output .= $this->renderModule(array('sidebarName' => $sidebarName, 'gridSize' => $gridSize, 'extraClass' => $extraClass));
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
    /* cada renderer é responsável pela renderizaçãoo do seu layout */
    public function renderModule($params = array(), $chrome = 'standard')
    {
        $output = '';
        $output .= '<div class="' . $params["extraClass"] . '">
                        <div id="' . $params["sidebarName"] . '">
                          <jdoc:include type="modules" name="' . $params["sidebarName"] . '" style="' . $chrome . '" />' . "\n" . '
                        </div>
                    </div>';
        return $output;
    }

    public function renderContent($params = array())
    {
        global $jflt;
        $output = '';
        $output = '<div class=" ' . $params["extraClass"] . '">

                    <div id="content-top">
                        <div class="container">
                       ';
        $output .= $jflt->displayModules('content-top');
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
        $output .= $jflt->displayModules('content-bottom');
        $output .= '   <div class="clear"></div>
                         </div>
                    </div>
                  </div>';
        return $output;
    }

}
