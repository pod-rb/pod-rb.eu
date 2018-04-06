<div class="bv_page_wide" style="display:block;background:#fff;padding-right:1%;overflow:hidden; margin-right:2.5%;margin-top:1%;"> <!-- SOWP MAIN -->

	<div class="bv_inside_heading" style="padding:0.25% 0 0 2%;overflow:hidden;border-bottom:1px solid #ebebeb;">
	<a href="<?php echo $this->getWebPage() ?>"><img src="<?php echo plugins_url($this->getPluginLogo(), __FILE__); ?>" /></a>
	</div>


	<div style="overflow:hidden;">	<!-- SOP 1 -->
			<div class="bv_inside_column1" style="width:100%;max-width:75%;float:left;padding:1% 2.5% 1% 2.5%;border-right:1px solid #ebebeb;overflow:hidden;"> <!-- MCA -->
<?php if (!isset($_REQUEST['free'])) { ?>
						<div align="center" style="margin-bottom: 25px;">
<?php if ($this->bvmain->getBrandName() === 'MalCare - Pro') {?>
							<iframe id="video" width="360" height="240" src="//www.youtube.com/embed/rBuYh2dIadk?rel=0" frameborder="0" allowfullscreen></iframe>
<?php } else {?>
							<iframe style="border: 1px solid gray; padding: 3px;" src="https://player.vimeo.com/video/88638675?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="450" height="275" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
<?php }?>					
						</div>
<?php } ?>


<?php
		if ($this->bvmain->isConfigured()) {
?>
		<div style="display:table;table-layout:fixed;width:100%;float:left;padding:1% 2.5% 2em 2.5%;overflow:hidden;" id="form_wr<?php echo $this->bvmain->appUrl()?>apper">
		<font size='3'><a href=<?php echo $this->bvmain->appUrl()?> target="_blank">Click here</a> to access <?php echo $this->bvmain->getBrandName()?> Dashboard</font>
				<br/><br/>
		</div>
<?php } else { ?>
<!-- form wrapper starts here-->
<div style="display:table;table-layout:fixed;width:100%;max-width:40%;float:left;padding:1% 2.5% 2em 2.5%;overflow:hidden;border: 1px solid #ebebeb;" id="form_wrapper">
<?php if (!isset($_REQUEST['signin'])) { ?>
			<!-- Signup form starts here -->
			<div>
				<h2><div style="display:block;padding-bottom:1%;">Create a BlogVault Account!</div></h2>
				<span style="color:grey;padding:1% 2.5% 0 2.5%;">All plans(<a href="https://blogvault.net/pricing?bvsrc=wpplugin&wpurl=<?php echo urlencode($this->bvmain->info->wpurl()) ?>">See Pricing</a>) come with free 1 week trial.</span>
			</div>

			<form dummy=">" action="<?php echo $this->bvmain->appUrl(); ?>/home/api_signup" style="padding:0 2% 2em 1%;" method="post" name="signup">
				<input type='hidden' name='bvsrc' value='wpplugin' />
<?php echo $this->siteInfoTags(); ?>
				<table style="border-spacing:0px 10px;">
					<tr>
						<td><label id='label_email'><strong>Email</strong></label></td>
						<td><input type="text" id="email" name="email" value="<?php echo get_option('admin_email');?>"></td>
					</tr>
					<tr>
						<td><label id='label_password'><strong>Password</strong></label></td>
						<td><input type="password" name="password" id="password"></td>
					</tr>
					<tr>
						<td><label><strong>Confirm Password</strong></label></td>
						<td><input type="password" name="password_confirmation" id="confirm_password"></td>
					</tr>
					<tr>
						<td><label><strong>Plan</strong></label></td>
						<td>
							<select name="plan">
								<option value="1sitey" selected>1 Site - $89/year</option>
								<option value="3sitey">3 Sites - $189/year</option>
								<option value="7sitey">7 Sites - $389/year</option>
								<option value="dev99m">Unlimited - $99/month</option>
							</select>
						</td>
					</tr>
				<tr>
					<td></td>
					<td><button type="submit">Register</button></td>
				</tr>
				<tr>
					<td></td>
					<td><p><b>Already have an account? </b><a href="<?php echo $this->mainUrl('&signin=true'); ?>">Sign in</a></p></td>
				</tr>
				</table>
			</form>

			<!-- Signup form end here -->
<?php } else { ?>
			<!-- Signin form end here -->
			<div>
			  <font size="3">Login to your BlogVault Account!</font>
			</div>
			<form dummy=">" action="<?php echo $this->bvmain->appUrl(); ?>/home/api_signin" style="padding:0 2% 2em 1%;" method="post" name="signin">
				<input type='hidden' name='bvsrc' value='wpplugin' />
<?php echo $this->siteInfoTags(); ?>
				<table style="border-spacing:50px 10px;">
					<tr>
						<td><label><strong>Email</strong></label></td>
						<td><input type="text" name="email" /></td>
					</tr>
					<tr>
						<td width="115"><label><strong>Password</strong></label></td>
						<td><input type="password" name="password" /></td>
					<tr/>
					<tr>
						<td></td>
						<td align="right"><button type="submit">Sign In</button></td>
					</tr>
					<tr>
						<td></td>
						<td align="right"><a href=<?php echo $this->bvmain->appUrl()?>"/password_resets/new?bvsrc=wpplugin&wpurl=<?php echo urlencode($this->bvmain->info->wpurl()) ?>" target="_blank">Forgot Password</a></td>
					</tr>
					<tr>
						<td></td>
						<td align="right"><p><b>New to BlogVault? </b><a href="<?php echo $this->mainUrl(); ?>">Sign up</a></p></td>
					</tr>
				</table>
			</form>

<?php } ?>
		</div>	<!-- Signin  form ends here -->
		<div class="bv_3part_column1" style="width:100%;max-width:45%;float:left;padding:3% 2.5% 0 2.5%;overflow:hidden;">
					<div style="width:100%;overflow:hidden; margin-bottom: 10px;">
								<blockquote><span class="bqstart" style="float:left;font-size:400%;color:#cfcfcf;">&#8220;</span><h2>BlogVault is my favorite way to backup, migrate, and restore WordPress websites.&nbsp;&nbsp;<font size='2'><a href="http://bit.ly/mightyreview" style="text-decoration:none;" align="right" target="_blank">Read the complete review.</a></font></h2> <span style="float:right;"> - Kristin &#38; Mickey &#64; <a href="http://www.mightyminnow.com" style="text-decoration:none;" target="_blank">MIGHTYminnow</a> <font size='1'>(A Top WordPress Agency)</font></span></blockquote>
					</div>
				<font size='2' color="gray">As seen on:</font>
				<div align="center" style="padding-top:3%;"><img src="<?php echo plugins_url('../img/as_seen_in.png', __FILE__); ?>" /></div>
		</div>

	<?php
	}
?>
			</div> <!-- MCA -->
	</div> <!-- EOP 1 -->

</div> <!-- EOWP MAIN -->