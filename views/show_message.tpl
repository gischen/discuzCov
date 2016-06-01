<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xml:lang="zh-cn" lang="zh-cn" xmlns="http://www.w3.org/1999/xhtml"> 
	<head>
	    <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
		<title>提示信息</title>
		
		<style type="text/css">
		body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{margin:0;padding:0;}
		table{border-collapse:collapse;border-spacing:0;width:100%;}
		address,caption,cite,code,dfn,th,var{font-style:normal;font-weight:400;}
		ol,ul{list-style:none;}
		caption,th{text-align:left;}
		h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:400;}
		q:before,q:after{content:'';}
		address{display:inline;}
		body{background:#fff;color:#1c2837;font:normal 15px arial, verdana, tahoma, sans-serif;position:relative;}
		h3,h4,h5,h6,strong{font-weight:700;}
		em{font-style:italic;}
		img,.input_check,.input_radio{vertical-align:middle;}
		td{padding:3px;}
		h2{font-size:15px;font-weight:400;clear:both;margin:0 0 8px;}
		body h3{font-weight:700;font-size:15px;color:#1d3652;padding:5px 8px 3px;}
		h3 img{margin-top:-2px;}
		h3 a{text-decoration:none;}
		a{color:#284b72;}
		a:hover{color:#528f6c;text-decoration:underline;}
		#ipboard_body.redirector{width:500px;margin:150px auto 0;}
		.message{border-radius:3px;background:#f1f6ec;border:1px solid #b0ce94;color:#3e4934;line-height:150%;padding:10px 10px 10px 30px;}
		.message h3{color:#323232;padding:0;}
		.message.error{background-color:#f3dddd;color:#281b1b;font-size:15px;border-color:#deb7b7;}
		.message.error.usercp{background-image:none;float:right;padding:4px;}
		.message.unspecific{background-color:#f3f3f3;color:#515151;clear:both;border-color:#d4d4d4;margin:0 0 10px;}
		.message.user_status{background:#f9f7e0;color:#6c6141;font-size:15px;border:1px solid #eadca0;margin-bottom:10px;padding:5px 5px 5px 15px;}
		.message.user_status.in_profile{font-size:15px;position:relative;padding-left:15px;overflow:auto;}
		.message.user_status #update_status{background:#243f5c;font-size:15px;font-weight:700;margin-left:10px;padding:3px 8px;}
		.message.user_status .cancel{font-size:15px;}
		fieldset,img,abbr,acronym{border:0;}
		hr,legend{display:none;}
		</style>
		
		<!--/CSS-->
		
		<?php if ($_POST) { ?>
		<script type='text/javascript'>
		//<![CDATA[
		setTimeout("post_redirect()", 3000);
		
		function post_redirect()
		{
			document.getElementById('redirect_form').submit();
		}
		//>
		</script>
		<?php } ?>
	</head>
	<body id='ipboard_body' class='redirector'>
		<form id="redirect_form" action="" method="post">
		<?php if ($_POST) { ?>
		<?php foreach ($_POST AS $key => $val) { ?>
			<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val; ?>">
		<?php } ?>
		<?php } ?>
		</form>
		
		<div id='ipbwrapper'>
			<h1></h1>
			<h2>提示信息</h2>
			<p class='message'>
				<strong><?php echo $this->message; ?></strong>
				<br />
				<?php if ($_POST) { ?>
				<br />
				<span class='desc' id="redirect_desc">(<a href="javascript:;" onclick="document.getElementById('redirect_form').submit(); document.getElementById('redirect_desc').style.display='none';">如果不想等待, 请点击这里</a>)</span>
				<?php } ?>
			</p>
		</div>
	</body>
</html>