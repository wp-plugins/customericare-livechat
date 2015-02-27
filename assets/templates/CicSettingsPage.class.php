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

            <div>
                <a id="sign-in" class="button-primary" target="_blank" href="<?=$link?>">Sign In</a>
            </div>
        </section>
    <?php
    }
}
