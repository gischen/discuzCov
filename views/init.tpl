<?php TPL::output('header.tpl'); ?>

			
<div class="block">
			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
					
		<h2>准备就绪</h2>
	</div>		<!-- .block_head ends -->
				
	<div class="block_content">
		<form action="" method="post">
			<input type="hidden" name="page" value="1" /> 
			<input type="hidden" name="act" value="clean_up" /> 
			<input type="hidden" name="db_config_serialize" value="<?php echo base64_encode(serialize($_POST['db_config'])); ?>" /> 
			
			<p>
				<label>转换附件:</label> <input type="checkbox" class="checkbox" name="convert_attach" value="1" /> 
			</p>
			
			<p>
				<label>Anwsion 程序绝对路径 (转换附件必填, 当前转换程序路径: <?php echo dirname(__FILE__); ?>):</label><br />
				<input type="text" class="text small" name="anwsion_dir" value="" /> 
			</p>
			
			<p>
				<label>Discuz 附件目录绝对路径 (转换附件必填):</label><br />
				<input type="text" class="text small" name="discuz_attach_dir" value="" /> 
			</p>
			
			<p>
				<label>注册后默认关注的用户 id (多个用英文逗号分隔):</label><br />
				<input type="text" class="text small" name="focus_uids" value="1" /> 
			</p>
			
			<p>
				<label>每个批次处理数据条数:</label><br />
				<input type="text" class="text small" name="pre_page" value="500" /> 
			</p>
			
			<p>
				<input type="submit" class="submit mid" value="继 续" />
			</p>
		</form>
					
					
	</div>		<!-- .block_content ends -->
				
	<div class="bendl"></div>
	<div class="bendr"></div>
					
</div>		<!-- .block ends -->

<?php TPL::output('footer.tpl'); ?>