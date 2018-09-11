<?php 
//Si la variable liens_img n'est pas vide
if(!empty($liens_img)){
    $checkimg = 0;
    //On parcours le tableau $liens img et on place les resultat dans $value.
    foreach ($liens_img as $value) {
        $checkimg ++;
        $value1 = str_replace(' ', '&', $value); //on remplace les espaces par des carractères spéciaux
        $value2 = str_replace('.', 'é', $value1);// et on remplace les points par des caractère spéciaux
        $valueLink = str_replace($liens_absolu.'/vue/', '../../', $value);
    ?>

            <!--On affiche les résultat sous form de checkbox-->
            <label <?php echo 'for="'.$checkimg.'"'; ?> id="thumbnail_form"><img <?php echo 'src="'. implode($valueLink) .'"';?> alt="img" class="img rounded" height="100" width="200" ></label><input type="checkbox" class="checking_box" <?php echo 'id="'.$checkimg.'" name="'.implode($value2).'"' ?> />
    <?php
        
        }
}