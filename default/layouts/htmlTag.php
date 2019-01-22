<?php if($data->tagName == 'br') { echo '<br />'; } else { ?>
<{prop tagName} <?php if (strpos($data->id, 'unique') !== 0){ echo 'id="'.$data->id.'"';} ?>{attr name} {attr type} {attr class} {attr style} {attr value} {attr selected} {attr href} {attr src} {attr onClick} {attr onChange}  {attr onSubmit} {attr onMouseOver} {attr onMouseOut} {attr onKeyUp} {attr onKeyDown} {attr onKeyPress} {attr title} {attr placeholder} {attr tabPosition}>{prop text}{children all}</{prop tagName}>
<?php } ?>
