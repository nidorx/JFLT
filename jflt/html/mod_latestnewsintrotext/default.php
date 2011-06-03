<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php
	$show_date	= $params->get( 'show_date', 0 );
	$show_date_type	= $params->get( 'show_date_type', 0 );
?>


<div id="lista-novidades" class="<?php echo $params->get('ullistcss'); ?>">

    <?php
    $quantOfItem = count($list);

    foreach ($list as $index => $item ) :  ?>

    <div class="item <?php echo $params->get('lilistcss');

    if($index==0){
         echo 'first';
    }
    else if($index==$quantOfItem-1){
        echo 'last';
    }
    ?>">
         <?php
		if($show_date==1) {
                    echo '<span class="data">';
			switch($show_date_type) {
				case 1:
					echo '<span class="'.$params->get('datecss').'">'.date("d F Y", strtotime($item->created)).'</span>';
					break;
				case 2:
					echo '<span class="'.$params->get('datecss').'">'.date("H:i", strtotime($item->created)).'</span>';
					break;
				default:
					echo '<span class="'.$params->get('datecss').'">'.date("d F Y H:i", strtotime($item->created)).'</span>';
					break;
			}
                         echo '</span>';
		}
?>

        <a href="<?php echo $item->link; ?>" class="<?php echo $params->get('titlecss'); ?>">
            <?php echo strip_tags($item->text) ?>
        </a><br />
       
            <?php echo strip_tags(substr($item->intro, 0, $params->get('characters'))); ?>
                <?php if ($params->get('truncated') == 0){ echo $params->get('truncatedtext');}?>
         
         <p class="readon-surround">
             <a class="<?php echo $params->get('readmorecss') ; ?> readon" href="<?php echo $item->link ; ?>"><span> Ler mais...</span>
             </a>
         </p>
   
    </div>



	
<?php endforeach; ?>

</div>



                          
                       


