{children [tagName=html.body]}
{children [tagName=html.head]}
<?php if (count($data->jsInstances)) { ?>
<script type="text/javascript">
    pzk_init(<?php echo json_encode($data->jsInstances) ?>);
</script>
<?php } ?>