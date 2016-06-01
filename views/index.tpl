<?php TPL::output('header.tpl'); ?>

			
<div class="block">
			
	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
					
		<h2>基本设置</h2>
	</div>		<!-- .block_head ends -->
				
	<div class="block_content">
		<div class="message info"><p>请输入数据库信息, 注意: 转换数据会清空 Anwsion 数据库导入新数据, 请知晓</p></div>
		
		<form action="" method="post">
			<input type="hidden" name="act" value="init" /> 
			<input type="hidden" name="db_config[anwsion][charset]" value="utf8" /> 
			
			<p>
				<label>Discuz 数据库主机:</label><br />
				<input type="text" class="text small" name="db_config[discuz][host]" value="localhost" /> 
			</p>
						
			<p>
				<label>Discuz 数据库账户:</label><br />
				<input type="text" class="text small" name="db_config[discuz][username]" value="" /> 
			</p>
			
			<p>
				<label>Discuz 数据库密码:</label><br />
				<input type="password" class="text small" name="db_config[discuz][password]" value="" /> 
			</p>
			
			<p>
				<label>Discuz 数据库名称:</label><br />
				<input type="text" class="text small" name="db_config[discuz][dbname]" value="" /> 
			</p>
			
			<p>
				<label>Discuz 数据表前缀:</label><br />
				<input type="text" class="text small" name="db_config[discuz][table_prefix]" value="pre_" /> 
			</p>
			
			<p>
				<label>Discuz 数据库编码:</label><br />
				<select class="styled" name="db_config[discuz][charset]">
					<option value="utf8">UTF-8</option>
					<option value="gbk">GBK</option>
				</select>
			</p>
												
			<hr />
			
			<p>
				<label>UCenter 数据库主机:</label><br />
				<input type="text" class="text small" name="db_config[ucenter][host]" value="localhost" /> 
			</p>
						
			<p>
				<label>UCenter 数据库账户:</label><br />
				<input type="text" class="text small" name="db_config[ucenter][username]" value="" /> 
			</p>
			
			<p>
				<label>UCenter 数据库密码:</label><br />
				<input type="password" class="text small" name="db_config[ucenter][password]" value="" /> 
			</p>
			
			<p>
				<label>UCenter 数据库名称:</label><br />
				<input type="text" class="text small" name="db_config[ucenter][dbname]" value="" /> 
			</p>
			
			<p>
				<label>UCenter 数据表前缀:</label><br />
				<input type="text" class="text small" name="db_config[ucenter][table_prefix]" value="pre_ucenter_" /> 
			</p>
			
			<p>
				<label>UCenter 数据库编码:</label><br />
				<select class="styled" name="db_config[ucenter][charset]">
					<option value="utf8">UTF-8</option>
					<option value="gbk">GBK</option>
				</select>
			</p>
			
			<hr />
			
			<p>
				<label>Anwsion 数据库主机:</label><br />
				<input type="text" class="text small" name="db_config[anwsion][host]" value="localhost" /> 
			</p>
						
			<p>
				<label>Anwsion 数据库账户:</label><br />
				<input type="text" class="text small" name="db_config[anwsion][username]" value="" /> 
			</p>
			
			<p>
				<label>Anwsion 数据库密码:</label><br />
				<input type="password" class="text small" name="db_config[anwsion][password]" value="" /> 
			</p>
			
			<p>
				<label>Anwsion 数据库名称:</label><br />
				<input type="text" class="text small" name="db_config[anwsion][dbname]" value="" /> 
			</p>
			
			<p>
				<label>Anwsion 数据表前缀:</label><br />
				<input type="text" class="text small" name="db_config[anwsion][table_prefix]" value="aws_" /> 
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