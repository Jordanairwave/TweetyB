                    <div class="twitterWrapper">
                        <div class="innerWrapper">
                            <h3><a href="https://twitter.com/SCREEN_NAME" title="SCREEN_NAME Twitter account" target="_blank">SCREEN_NAME</a></h3>
                            <?php foreach($response as $tweet) { ?>
                                  <p><?php echo linkable($tweet->text);?> - <?php echo twitter_time($tweet->created_at); ?></p>
                                  <p><a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $tweet->id_str;?>" title="Reply to tweet" target="_blank">reply</a> - <a href="https://twitter.com/intent/retweet?tweet_id=<?php echo $tweet->id_str;?>" title="Retweet this tweet" target="_blank">retweet</a> - <a href="https://twitter.com/intent/favorite?tweet_id=<?php echo $tweet->id_str;?>" title="Favorite this tweet" target="_blank">favorite</a></p>
                            <?php } ?>
                        </div>
                    </div>