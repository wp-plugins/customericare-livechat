<?php

class CicSettingsPage
{

    public function render($link)
    {
    ?>

        <section class="cic-section">

            <div class="cic-logo">
                <img src="<?php echo plugin_dir_url( __FILE__ ).'../img/logo.png'; ?>" alt="customericare" />
            </div>

            <div class="updated"><p></p></div>

			<?php
				$token = get_option('cic-token');
				if(empty($token))
					echo '<div id="info-sale" class="updated" style="display: block;"><p>Create account and get Your promotion!</p></div>';
					
				$d='';
				if( empty($token) )
					$d='display: none;';
			?>
			
			<div style="position: relative;">
				<div style="display: inline-block; width: 60%;">
            <div class="cic-content">
                <h3 id="new-licence-title" class="new-licence-title">I want to create a new account in CustomerICare</h3>
                <form id="cic-create-licence-form" method="post" action="?page=cic-admin-settings" autocomplete="off">
                    <label>E-mail:</label><br />
                    <input type="email" value="" name="cic-email" placeholder="john@smith.com" autocomplete="off" /><br />

                    <label>Password:</label><br />
                    <input type="password" value="" name="cic-pass" autocomplete="off" /><br />

                    <button id="create-new-licence" class="button-primary">Save</button>
                </form>
            </div>

            <div class="cic-content">
                <h3 id="new-plugin-title" class="new-plugin-title">I already have an account, I just want to install the chat box</h3>
                <form id="cic-add-plugin-form" method="post" action="?page=cic-admin-settings" autocomplete="off">
                    <label>E-mail:</label><br />
                    <input class="cic-apikey" type="hidden" name="cic-apikey" value="<?php echo get_option('cic-apikey'); ?>" placeholder="d9d4f495e875a2e075a1a4a6e1b9770f" autocomplete="off" />
                    <input class="cic-api-email" type="email" name="cic-api-email" value="<?php echo get_option('cic-api-email'); ?>" placeholder="john@smith.com" autocomplete="off" /><br />

                    <button id="add-plugin" class="button-primary">Save</button>
                </form>
            </div>
				</div>
				
				<div id="sign-in-one-payment-wrap" style="display: inline-block; width: 35%; margin-left: 30px; top: 0;position: absolute;border-left: 1px solid rgb(208, 208, 208);padding-left: 20px; <?=$d?>">
				
					<img src="<?php echo plugin_dir_url( __FILE__ ).'../img/one_payment.png'; ?>" alt="" style="width: 350px; margin-bottom: 30px;" />
				
					<p><strong>Using Paypal:</strong></p>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="margin-bottom: 10px;"> 
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="7VQ64XT2BDKCC">
						<input type="image" src="https://www.paypalobjects.com/en_US/PL/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
					<p style="margin-top: 0; font-size: 11px;">* change of payment plan in 24 hours</p>
					
					<p><strong>Using Credit Card:</strong></p>
					<a id="sign-in-one-payment" class="button-primary" target="_blank" href="<?=$link?>">Claim the $29 lifetime licence now!</a>
					<p style="margin-top: 3px; font-size: 11px;">* automatic change of payment plan</p>
				</div>

			<div>

            <div style="text-align: center;">
                <a id="sign-in" class="button-secondary" style="float: left;" target="_blank" href="<?=str_replace('&paylane=one', '', $link);?>">Sign In</a>
				

            </div>
        </section>
    <?php
    }
}
