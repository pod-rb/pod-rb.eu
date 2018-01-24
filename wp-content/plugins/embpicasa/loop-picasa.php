<?php
/**
 * $id - of selected album
 *
 * $photos array awailable here, each photo has: thumbnail, fullsize and title
 * something like this:
 *
 * Array
 * (
 *     [0] => Array
 *         (
 *             [thumbnail] => https://lh6.googleusercontent.com/-Ow09sijKJwc/SFotj3v0B5I/AAAAAAAAACo/RgARvfNjf50/s150/IMG_3849.JPG
 *             [fullsize] => https://lh6.googleusercontent.com/-Ow09sijKJwc/SFotj3v0B5I/AAAAAAAAACo/RgARvfNjf50/s640-c/IMG_3849.JPG
 *             [title] => 
 *         )
 * 
 *     [1] => Array
 *         (
 *             [thumbnail] => https://lh5.googleusercontent.com/-BzaiZVMT0jg/SFzNLsAG1EI/AAAAAAAAAF8/fA1HF4q8nrA/s150/IMG_3792.JPG
 *             [fullsize] => https://lh5.googleusercontent.com/-BzaiZVMT0jg/SFzNLsAG1EI/AAAAAAAAAF8/fA1HF4q8nrA/s640-c/IMG_3792.JPG
 *             [title] => 
 *         )
 * )
 */
?>

<ul class="embpicasa">
<?php foreach($photos as $photo):?>
	<li>
		<a title="<?php echo $photo['title']?>" rel="lightbox[<?php echo $id?>]" target="_blank" href="<?php echo $photo['fullsize']?>">
			<img src="<?php echo $photo['thumbnail']?>" alt="<?php echo $photo['title']?>" />
		</a>
	</li>
<?php endforeach;?>
</ul>