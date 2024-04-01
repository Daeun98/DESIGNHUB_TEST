
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
 <head>
  <title><?=$shop_info['shop_name']?></title>
  <meta name="Author" content="<?=$shop_info['shop_name']?>">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">


<? 
	$subject = $this->input->get("subject");
	$content = $this->input->get("content");

	$url = $this->input->get("url");

	if(!$subject){ $subject = "[".$shop_info['shop_name']."]"; }
	if(!$content){ $content = "http://".$_SERVER['HTTP_HOST']; }


?>

			<meta property="og:title" content="<?=$subject?>" />
			<meta property="og:description" content="<?=$content?>" />
			<meta property="article:section" content="<?=$shop_info['shop_name']?>" />

	</head>

	<script>

	<? if($subject && $content && $url){ ?>
		location.href="<?=$url?>";
	<?}?>

	</script>
</html>