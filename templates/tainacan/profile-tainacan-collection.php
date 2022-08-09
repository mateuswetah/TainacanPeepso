<div class="peepso ps-page-profile">
    <?php PeepSoTemplate::exec_template('general','navbar'); ?>

    <?php //PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'tainacan')); ?>

    <section id="mainbody" class="ps-page-unstyled ps-tainacan-profile">
        <section id="component" role="article" class="ps-clearfix">

            <?php

            // $view_user_id holds the id of currently viewed user
            $PeepSoUser = PeepSoUser::get_instance($view_user_id);
            
            $collections_url = $PeepSoUser->get_profileurl() . 'tainacan/';

            $tainacan_collections_repository = \Tainacan\Repositories\Collections::get_instance();
            $tainacan_collection = $tainacan_collections_repository->fetch($tainacan_collection_id, 'OBJECT');

            ?>
            
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 0.5em;">
                <h1><?php echo sprintf(__('Items for %s', 'tainacan-peepso'), $tainacan_collection->get_name()); ?></h1>
                <div class="ps-album__actions">
                    <a class="ps-btn ps-btn--sm" href="<?php echo $collections_url; ?>">
                        <i class="gcis gci-angle-left"></i>
                        <span>Back to collections</span>
                    </a>
                    <a class="ps-btn ps-btn--sm ps-btn--action" href="#" onclick="peepso.tainacan.show_item_dialog(<?php echo $tainacan_collection_id; ?>); return false;">
                        Add an item
                    </a>
                </div>
            </div>

            <?php
            
            tainacan_the_faceted_search([
                'collection_id' => $tainacan_collection_id,
                'hide_exposers_button' => true,
                'hide_go_to_page_button' => true,
                'show_filters_button_inside_search_control' => true,
                'start_with_filters_hidden' => true,
                'filters_as_modal' => true,
                'show_inline_view_mode_options' => true,
                'show_fullscreen_with_view_modes' => true
            ]);
            
            ?>

        </section><!--end component-->
    </section><!--end mainbody-->
</div><!--end row-->
<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>




