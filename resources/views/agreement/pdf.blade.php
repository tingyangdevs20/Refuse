<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		.page-break {
			page-break-after: always;
		}

		* {
			font-family: DejaVu Sans, sans-serif !important;
		}
	</style>
</head>

<body>
	{!! $content !!}
	<script type="text/php">
		if (isset($pdf)) {
	        $text = "page {PAGE_NUM} / {PAGE_COUNT}";
	        $size = 10;
	        $font = $fontMetrics->getFont("DejaVu Sans");
	        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
	        $x = ($pdf->get_width() - $width) / 2;
	        $y = $pdf->get_height() - 35;
	        $pdf->page_text($x, $y, $text, $font, $size);
	    }
	</script>
</body>

</html>