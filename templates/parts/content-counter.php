<?php
global $counter;
?>

<div class="col-xs-12 col-sm-4">
    <div class="counter">
        <?php
        $from = $counter['value'][0]['from'];
        $to = $counter['value'][0]['to'];
        ?>
        <div class="counter-value" data-from="<?php echo $from; ?>" data-to="<?php echo $to; ?>"><?php echo $from; ?></div>

        <p><?php echo $counter['title']; ?></p>
    </div>
</div>