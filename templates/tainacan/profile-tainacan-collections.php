<div class="peepso ps-page-profile">
    <?php PeepSoTemplate::exec_template('general','navbar'); ?>

    <?php PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'tainacan')); ?>

    <section id="mainbody" class="ps-page-unstyled ps-tainacan-profile">
        <section id="component" role="article" class="ps-clearfix">

            <?php

            // $view_user_id holds the id of currently viewed user
            $PeepSoUser = PeepSoUser::get_instance($view_user_id);
            $collections_url = $PeepSoUser->get_profileurl() . 'tainacan/';

            $tainacan_collections_repository = \Tainacan\Repositories\Collections::get_instance();
            $tainacan_collections = $tainacan_collections_repository->fetch([
                'author' => $view_user_id,
                'posts_per_page' => -1
            ], 'OBJECT');
            ?>

            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.5em;">
                <h1><?php             echo sprintf(__('Collections for %s', 'tainacan-peepso'), $PeepSoUser->get_fullname()); ?></h1>
            </div>
            <ul>
                <?php foreach($tainacan_collections as $tainacan_collection): ?>
                    <li>
                        <a href="<?php echo $collections_url . $tainacan_collection->get_id();  ?>">
                            <?php if ( $tainacan_collection->get_thumbnail() && isset($tainacan_collection->get_thumbnail()['medium']) ): ?>
                                <img src="<?php echo $tainacan_collection->get_thumbnail()['medium'][0]; ?>">
                            <?php endif; ?>
                            <span><?php echo $tainacan_collection->get_name(); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </section><!--end component-->
    </section><!--end mainbody-->
</div><!--end row-->
<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>




