<script type="text/javascript" src="/lib/js/date.js"></script>
	{?
		$classes = $data->getClasses();
		$arrcls = array();
		foreach($classes as $class) {
			$subjectId = $class['subjectId'];
			if(!isset($arrcls[$subjectId])) {
				$arrcls[$subjectId] = array();
			}
			$arrcls[$subjectId][] = $class;
		}
	?}
{each $arrcls as $clss}
<div id="paymentStatTab" class="easyui-tabs" style="width:1360px;height:auto;" data-options="onSelect: paymentStatTabSelect, href:'_content.html',closable:true">
	<div title="Thông tin">
		<h1><center>Thống kê thanh toán</center></h1>
	</div>
	{each $clss as $class}
	<div title="{class[name]}" data-options="href:'{url /demo/paymentStatTab}?classId={class[id]}',closable:true">
	</div>
	{/each}
</div>
{/each}
{children all}