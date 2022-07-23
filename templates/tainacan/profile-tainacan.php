<div class="peepso ps-page-profile">
    <?php PeepSoTemplate::exec_template('general','navbar'); ?>

    <?php PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'tainacan')); ?>

    <section id="mainbody" class="ps-page-unstyled ps-tainacan-profile">
        <section id="component" role="article" class="ps-clearfix">

            <?php

            // $view_user_id holds the id of currently viewed user
            $PeepSoUser = PeepSoUser::get_instance($view_user_id);

            echo sprintf(__('This is the Tainacan tab for %s', 'tainacan-peepso'), $PeepSoUser->get_fullname());
            ?>

        </section><!--end component-->
    </section><!--end mainbody-->
</div><!--end row-->
<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>




