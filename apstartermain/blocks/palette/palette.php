<?php

/*
 ** Block Name: Palette
 */

if (is_admin()) {
    include __DIR__ . '/admin.php';
    return;
}

$palette_card = get_field('palette_card');
?>

<section class="palette">
    <div class="palette__main-wrapper">
        <?php 
        $counter = 0;
        $wrapper_counter = 0;
        $total_palettes = count($palette_card);
        foreach($palette_card as $index => $palette) { 
            if ($counter % 2 == 0) {
                if ($counter > 0) {
                    echo '</div>';
                }
                $wrapper_class = ($wrapper_counter % 2 == 1) ? 'palette__column-wrapper even' : 'palette__column-wrapper';
                echo '<div class="' . $wrapper_class . '">';
                $wrapper_counter++;
            }
            ?>
            <div class="palette__single" style="background-color: <?php echo $palette['background_color']; ?>">
                <h3 class="w-500" style="color: <?php echo $palette['text_color']; ?>"><?php echo $palette['title']; ?></h3>
                <h3 class="w-500 color-output" style="color: <?php echo $palette['text_color']; ?>"><?php echo $palette['color_code']; ?></h3>
                <p class="p-big w-500" style="color: <?php echo $palette['text_color']; ?>"><?php echo $palette['brief']; ?></p>
            </div>
            <?php 
            $counter++;
        } 
        if ($total_palettes % 2 != 0) {
            echo '</div>';
        }
        ?>
    </div>
</section>