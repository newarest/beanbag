<?php
if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
               mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}
function woo_bb_options_page(){
    if ( !current_user_can('manage_options') )
    wp_die( __('You do not have sufficient permissions to access this page.', 'woocommerce-beanbag-pattern') ); 
?>
    <h2>Настройки выбора тканей для кресел beanbag</h2>
    
    <div id="content">

	<h2 class="nav-tab-wrapper add_tip_wrap">    
<?php
    $bb_pattern_descr = array('oxford' => 'Ткань "Оксфорд" - прочная синтетическая ткань, используемая для пошива рюкзаков, сумок. Сейчас ее используют и для пошива бескаркасной мебели. С тыльной стороны имеет водоотталкивающий слой, благодаря чему изделия из этого материала можно использовать как в помещении, так и на улице. "Оксфорд" не боится загрязнений - большинство загрязнений с ткани удаляется обычной влажной тряпкой.', 'zeus' => 'Качественная искусственная мебельная кожа, приятна на ощупь и очень эластична. Имеет тканевую основу (коттон + полистер) и покрытие из полиуретана, благодаря чему поверхность материала устойчива к загрязнениям и влаге. Один из наиболее удачных, на наш взгляд, материалов для кресел-мешков, т.к. кресла из него получаются особенно мягкими и удобными. Изделия из кожзаменителя рекомендуется заказывать без внутреннего чехла.', 'zeus-deluxe' => 'Качественная искусственная мебельная кожа, приятна на ощупь и очень эластична. Имеет тканевую основу (коттон + полистер) и покрытие из полиуретана, благодаря чему поверхность материала устойчива к загрязнениям и влаге. Один из наиболее удачных, на наш взгляд, материалов для кресел-мешков, т.к. кресла из него получаются особенно мягкими и удобными. Изделия из кожзаменителя рекомендуется заказывать без внутреннего чехла.', 'rainbow' => 'Высококачественный кожзаменитель, аналогичный по составу и свойствам кожзаменителю Zeus (имеет в основе полиэстер 67% + коттон 33%, поверхность - полиуретан) . Обладает такой же мягкостью, эластичностью и долговечностью, устойчив к многократному сгибанию, трению. Вся коллекция кожзаменителя Рейнбоу имеет яркие, сочные цвета и глянцевый блеск.' );
    $img_catalogs = array();//папки с названиями тканей 
    $img_pics = array(); //пути к картинкам в этих папках
    $img_descr = array(); //пути к картинкам в этих папках
    $i = 0;
    foreach (glob(IMAGE_PATH."/*") as $v){
        $fname=basename($v);
        $img_catalogs[] = $fname;
        if ($i == 0) {
?>
        <a class="bb-tab nav-tab <?php echo $fname; ?>-tab nav-tab-active"  data-target="#<?php echo $fname; ?>"><?php _e( strtoupper($fname), 'woocommerce-beanbag-pattern' ); ?></a>
<?php } else { ?>
        <a class="bb-tab nav-tab <?php echo $fname; ?>-tab" data-target="#<?php echo $fname; ?>"><?php _e( strtoupper($fname), 'woocommerce-beanbag-pattern' ); ?></a>
	
	
	<?php  }
        $img_pics[$fname]['descr'] = $bb_pattern_descr [$fname];
        $i++;
            $j=0;
        foreach (glob( IMAGE_PATH.$fname."/*") as  $img){
             $img_name=basename($img);
             $img_pics[$fname][] = IMAGE_URL. $fname. '/'. $img_name;
             $img_pics[$fname][$fname.''.$j] = $fname; 
            
             $j++;
                        
         }
        
        add_option( 'bb_'.$fname, $img_pics[$fname] );
       // update_option( 'bb_'.$fname.'_name', $img_descr[$fname] );
    }    
    ?>
    </h2>
	<!-- .nav-tab-wrapper -->
	
<?php
    //print_r($img_pics);
    foreach($img_catalogs as $opt_name){
        
        if(isset($_POST['bb_'.$opt_name.'_submit'])){
            $newVal = array();
           
            foreach($_POST as $name => $value){
                if( strripos($name, 'bb_'.$opt_name.'_submit')!== false) continue;
                else $newVal[$name] = $value;
            }
            //print_r($bb_option);
            //echo "<br>";
             //print_r($newVal);
            $res = update_option('bb_'.$opt_name, $newVal);
            $bb_option = $newVal;
        }
        else $bb_option = get_option( 'bb_'.$opt_name );
        $wrap =  '<div class="wrap bb-wrap clearfix" id="'.$opt_name.'">
        <h2>Файлы ткани '.strtoupper($opt_name).'</h2>
        <form name="bb_'.$opt_name.'" method="post">';
        foreach($bb_option as $num => $file) {
            if( strripos($num, $opt_name)!== false) continue;
            else if($num === "descr") $wrap.= '<p class="bb-full-width">
            <label for="'.$opt_name.'-descr">Описание ткани</label>
            <textarea cols="50" rows="6" id="'.$opt_name.'-descr" name="descr">'.stripslashes_deep($bb_option["descr"]).'</textarea></p>
            <h3>Введите наименование тканей</h3>';
            
            else 
            $wrap .= '<p><img src="'.$file.'">
            <input type="hidden" name="'.$num.'" value="'.$file.'">
            <input type="text" name="'.$opt_name."".$num.'" value="'.trim(mb_convert_case($bb_option[$opt_name."".$num], MB_CASE_TITLE, 'UTF-8')).'"></p>';
            //$wrap .= '<p><img src="'.$file.'"><input type="text" name="'.$opt_name.$num.'" value="'.$opt_name.' "></p>';
            //echo $bb_option[$opt_name."".$num].",";
        }
        $wrap .='<p><input type="submit" value="Сохранить изменения" class="button button-primary button-large" name="bb_'.$opt_name.'_submit"></p>';
        $wrap .='</form></div><!--/ .wrap-->';
        echo $wrap;
    }
   
    echo '</div><!-- /#content -->';
    
}