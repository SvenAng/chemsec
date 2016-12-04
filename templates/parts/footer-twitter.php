<?php
$tweets = get_tweets();
$latest_tweet = $tweets->status;
?>

<div class="tweets">
    <div class="tweet">
        <?php echo $latest_tweet->text; ?>
    </div>
</div>